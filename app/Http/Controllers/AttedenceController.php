<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Office;
use App\Services\AttendanceService;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttedenceController extends Controller
{
    protected AttendanceService $attendanceService;
    protected GeoLocationService $geoLocationService;

    public function __construct(
        AttendanceService $attendanceService,
        GeoLocationService $geoLocationService
    ) {
        $this->attendanceService = $attendanceService;
        $this->geoLocationService = $geoLocationService;
    }

    // Halaman absen biasa
    public function index()
    {
        $userId = Auth::id();
        $todayAttendance = Attendance::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->where('type', 'masuk')
            ->first();

        $type = $todayAttendance ? 'pulang' : 'masuk';

        return view('components.features.employes.attedance.attedance-work.attedance', compact('type'));
    }

    // API untuk mencari kantor terdekat
    public function getClosestOffice(Request $request)
    {
        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $lat = $request->input('latitude');
        $lon = $request->input('longitude');

        // Prevent N+1 queries by retrieving all offices at once
        $offices = Office::all();
        $closestOffice = null;
        $minDistance = null;

        foreach ($offices as $office) {
            $dist = $this->geoLocationService->calculateDistance($lat, $lon, $office->latitude, $office->longitude);
            if ($minDistance === null || $dist < $minDistance) {
                $minDistance = $dist;
                $closestOffice = $office;
            }
        }

        if (!$closestOffice) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada kantor terdaftar.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'office' => $closestOffice,
            'distance' => $minDistance, // in meters
            'within_radius' => $minDistance <= $closestOffice->radius
        ]);
    }

    // Absen aksi (selfie)
    public function attedanceAction(Request $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');
        $type = $request->query('type', 'masuk');

        if (!$lat || !$lon) {
            return redirect()->route('attendance.index')->with('error', 'Koordinat lokasi GPS tidak lengkap.');
        }

        // Prevent N+1 queries by retrieving all offices
        $offices = Office::all();
        $closestOffice = null;
        $minDistance = null;

        foreach ($offices as $office) {
            $dist = $this->geoLocationService->calculateDistance($lat, $lon, $office->latitude, $office->longitude);
            if ($minDistance === null || $dist < $minDistance) {
                $minDistance = $dist;
                $closestOffice = $office;
            }
        }

        if (!$closestOffice) {
            return redirect()->route('attendance.index')->with('error', 'Tidak ada lokasi kantor yang dikonfigurasi.');
        }

        // Enforce strict 100 meters geofencing limit
        $maxRadius = min(100.0, (float)$closestOffice->radius);

        if ($minDistance > $maxRadius) {
            return redirect()->route('attendance.index')->with('error', 'Absensi diblokir: Jarak Anda (' . round($minDistance, 1) . 'm) melebihi radius batas kantor ' . $closestOffice->name . ' (' . $maxRadius . 'm).');
        }

        return view('components.features.employes.attedance.attedance-work.attedance-action', compact('type'));
    }

    // Submit absensi (verifikasi wajah & lokasi)
    public function submit(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:masuk,pulang'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'face_descriptor' => ['required', 'array'],
            'face_descriptor.*' => ['required', 'numeric'],
            'snapshot' => ['required', 'string'], // base64
        ]);

        $userId = Auth::id();
        $type = $request->input('type');
        $lat = $request->input('latitude');
        $lon = $request->input('longitude');
        $descriptor = $request->input('face_descriptor');
        $snapshot = $request->input('snapshot');

        $result = $this->attendanceService->submitAttendance($userId, $type, $lat, $lon, $descriptor, $snapshot);

        if ($result['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => 'Absensi berhasil dicatat!',
                'data' => [
                    'matching_score' => $result['matching_score'],
                    'distance' => $result['distance'],
                    'office_name' => $result['office_name']
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message']
        ], 400);
    }

    // Absen sukses alert 
    public function attedanceSuccess()
    {
        $userId = Auth::id();
        
        // Find the latest successful attendance for today
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', today())
            ->orderBy('id', 'desc')
            ->first();
            
        // If not found, fall back to the absolute latest attendance ever
        if (!$attendance) {
            $attendance = Attendance::where('user_id', $userId)
                ->orderBy('id', 'desc')
                ->first();
        }
        
        // Find the associated office and distance
        $office = null;
        $distance = null;
        if ($attendance) {
            $office = Office::find($attendance->office_id);
            if ($office) {
                $distance = $this->geoLocationService->calculateDistance(
                    $attendance->latitude,
                    $attendance->longitude,
                    $office->latitude,
                    $office->longitude
                );
            }
        }

        return view('components.features.employes.attedance.alert-attedance.attedance-success', compact('attendance', 'office', 'distance'));
    }

    // Halaman absen sholat (riwayat)
    public function attedanceIshomaIndex()
    {
        return view('components.features.employes.attedance.attdance-ishoma.index');
    }

    public function attedanceIshoma()
    {
        return view('components.features.employes.attedance.attdance-ishoma.attedance-ishoma');
    }
}
