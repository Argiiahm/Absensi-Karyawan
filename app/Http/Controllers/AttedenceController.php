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
            ->whereDate('date', today())
            ->where('type', 'masuk')
            ->first();

        $type = $todayAttendance ? 'pulang' : 'masuk';
        $office = Office::first();

        $isAllowed = true;
        $reason = '';
        $scheduleTime = '';

        if ($office) {
            $now = now();
            if ($type === 'masuk') {
                $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $office->start_time);
                $allowedStartTime = $startTime->copy()->subMinutes(10);
                $scheduleTime = substr($office->start_time, 0, 5) . ' (Bisa absen mulai ' . $allowedStartTime->format('H:i') . ')';
                if ($now->lt($allowedStartTime)) {
                    $isAllowed = false;
                    $reason = 'Belum waktunya absen masuk. Absen dibuka 10 menit sebelum jam masuk (' . $allowedStartTime->format('H:i') . ' WIB).';
                }
            } else {
                $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $office->end_time);
                $scheduleTime = substr($office->end_time, 0, 5);
                if ($now->lt($endTime)) {
                    $isAllowed = false;
                    $reason = 'Belum waktunya absen pulang. Absen pulang dibuka mulai jam ' . $endTime->format('H:i') . ' WIB.';
                }
            }
        }

        return view('components.features.employes.attedance.attedance-work.attedance', compact('type', 'isAllowed', 'reason', 'scheduleTime', 'office'));
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

        // Enforce time validation
        $now = now();
        if ($type === 'masuk') {
            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $closestOffice->start_time);
            $allowedStartTime = $startTime->copy()->subMinutes(10);
            if ($now->lt($allowedStartTime)) {
                return redirect()->route('attendance.index')->with('error', 'Belum waktunya absen masuk. Pintu absen masuk dibuka jam ' . $allowedStartTime->format('H:i') . ' WIB.');
            }
        } elseif ($type === 'pulang') {
            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $closestOffice->end_time);
            if ($now->lt($endTime)) {
                return redirect()->route('attendance.index')->with('error', 'Belum waktunya absen pulang. Pintu absen pulang dibuka jam ' . $endTime->format('H:i') . ' WIB.');
            }
        } elseif (in_array($type, ['subuh', 'zuhur', 'asar', 'maghrib', 'isya'])) {
            $prayerTimes = [
                'subuh'   => '04:38',
                'zuhur'   => '12:05',
                'asar'    => '15:28',
                'maghrib' => '18:10',
                'isya'    => '19:20',
            ];
            $pTime = \Carbon\Carbon::createFromFormat('H:i', $prayerTimes[$type]);
            if ($now->lt($pTime)) {
                return redirect('/attedance/ishoma/index')->with('error', 'Belum waktunya sholat ' . ucfirst($type) . ' (' . $prayerTimes[$type] . ' WIB).');
            }
        }

        return view('components.features.employes.attedance.attedance-work.attedance-action', compact('type'));
    }

    // Submit absensi (verifikasi wajah & lokasi)
    public function submit(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:masuk,pulang,subuh,zuhur,asar,maghrib,isya'],
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
        
        // Eager load 'office' to prevent an extra query (N+1 elimination)
        $attendance = Attendance::with('office')
            ->where('user_id', $userId)
            ->whereDate('date', today())
            ->orderBy('id', 'desc')
            ->first();
            
        // If not found today, fall back to the absolute latest attendance ever
        if (!$attendance) {
            $attendance = Attendance::with('office')
                ->where('user_id', $userId)
                ->orderBy('id', 'desc')
                ->first();
        }
        
        // Calculate distance using the eagerly-loaded office (no extra query)
        $office   = $attendance?->office;
        $distance = null;
        if ($attendance && $office) {
            $distance = $this->geoLocationService->calculateDistance(
                $attendance->latitude,
                $attendance->longitude,
                $office->latitude,
                $office->longitude
            );
        }

        return view('components.features.employes.attedance.alert-attedance.attedance-success', compact('attendance', 'office', 'distance'));
    }

    // Halaman absen sholat (riwayat)
    public function attedanceIshomaIndex()
    {
        $userId = Auth::id();
        $todayPrayers = Attendance::where('user_id', $userId)
            ->whereDate('date', today())
            ->whereIn('type', ['subuh', 'zuhur', 'asar', 'maghrib', 'isya'])
            ->get()
            ->keyBy('type');

        $office = Office::first();

        return view('components.features.employes.attedance.attdance-ishoma.index', compact('todayPrayers', 'office'));
    }

    public function attedanceIshoma(Request $request)
    {
        $type = $request->query('type', 'zuhur');

        if (!in_array($type, ['subuh', 'zuhur', 'asar', 'maghrib', 'isya'])) {
            return redirect('/attedance/ishoma/index')->with('error', 'Waktu sholat tidak valid.');
        }

        return view('components.features.employes.attedance.attdance-ishoma.attedance-ishoma', compact('type'));
    }
}
