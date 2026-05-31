<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'employee',
            'is_face_enrolled' => false,
        ]);

        Auth::login($user);

        return $user;
    }

    public function login(array $credentials): bool
    {
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
