<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\FaceEnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;
    protected FaceEnrollmentService $faceEnrollmentService;

    public function __construct(AuthService $authService, FaceEnrollmentService $faceEnrollmentService)
    {
        $this->authService = $authService;
        $this->faceEnrollmentService = $faceEnrollmentService;
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('components.features.auth.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($this->authService->login($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            if (!$user->is_face_enrolled) {
                return redirect()->route('face.enrollment');
            }
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('components.features.auth.register');
    }

    public function handleRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Store pending registration data in session
        session(['pending_registration' => $data]);

        return redirect()->route('face.enrollment');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }

    public function faceEnrollmentView()
    {
        if (Auth::check()) {
            if (Auth::user()->is_face_enrolled) {
                return redirect('/');
            }
        } elseif (!session()->has('pending_registration')) {
            return redirect()->route('register');
        }

        return view('components.features.auth.face-enrollment');
    }

    public function faceEnrollmentStore(Request $request)
    {
        $request->validate([
            'face_descriptor' => ['required', 'array'],
            'face_descriptor.*' => ['required', 'numeric'],
        ]);

        $descriptor = $request->input('face_descriptor');

        if (Auth::check()) {
            $userId = Auth::id();
            try {
                $success = $this->faceEnrollmentService->enroll($userId, $descriptor);
                if ($success) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Registrasi wajah berhasil!'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        } elseif (session()->has('pending_registration')) {
            $pendingData = session('pending_registration');
            $user = null;
            try {
                // Register and log in the user first
                $user = $this->authService->register($pendingData);
                
                // Save the face descriptor
                $success = $this->faceEnrollmentService->enroll($user->id, $descriptor);
                
                if ($success) {
                    // Clear pending session
                    session()->forget('pending_registration');
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Registrasi wajah berhasil!'
                    ]);
                } else {
                    // Clean up user if enrollment failed
                    if ($user) {
                        $user->delete();
                    }
                    Auth::logout();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan biometrik wajah. Silakan coba lagi.'
                    ], 500);
                }
            } catch (\Exception $e) {
                // Clean up user if exception occurred
                if ($user) {
                    $user->delete();
                }
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi pendaftaran tidak ditemukan. Silakan register ulang.'
            ], 403);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal melakukan registrasi wajah.'
        ], 500);
    }
}
