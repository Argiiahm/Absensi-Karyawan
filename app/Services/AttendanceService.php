<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AttendanceService
{
    protected GeoLocationService $geoLocationService;

    public function __construct(GeoLocationService $geoLocationService)
    {
        $this->geoLocationService = $geoLocationService;
    }

    public function submitAttendance(int $userId, string $type, float $lat, float $lon, array $realtimeDescriptor, string $base64Snapshot)
    {
        $user = User::find($userId);
        if (!$user) {
            return [
                'status' => 'failed',
                'message' => 'Karyawan tidak ditemukan.'
            ];
        }

        // Check enrollment
        if (!$user->is_face_enrolled || !$user->face_descriptor) {
            return [
                'status' => 'failed',
                'message' => 'Anda belum melakukan pendaftaran wajah.'
            ];
        }

        // 1. Geofencing Validation
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

        // Save snapshot helper
        $snapshotPath = null;
        if ($base64Snapshot) {
            $snapshotData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Snapshot));
            if ($snapshotData !== false) {
                $filename = 'selfie_' . $userId . '_' . time() . '.jpg';
                $path = 'selfies/' . $filename;
                Storage::disk('public')->put($path, $snapshotData);
                $snapshotPath = '/storage/' . $path;
            }
        }

        // Validate office radius (strictly capped at 100 meters)
        $maxRadius = 100.0; // standard 100 meters
        if ($closestOffice) {
            $maxRadius = min(100.0, (float)$closestOffice->radius);
        } else {
            // No offices configured
            AttendanceLog::create([
                'user_id' => $userId,
                'type' => $type,
                'latitude' => $lat,
                'longitude' => $lon,
                'distance_to_office' => null,
                'face_matching_score' => null,
                'status' => 'failed',
                'error_message' => 'Tidak ada lokasi kantor yang dikonfigurasi.',
                'snapshot_path' => $snapshotPath,
            ]);

            return [
                'status' => 'failed',
                'message' => 'Kantor tidak terdaftar atau GPS bermasalah.'
            ];
        }

        // Enforce time validation
        $now = now();
        if ($type === 'masuk') {
            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $closestOffice->start_time);
            $allowedStartTime = $startTime->copy()->subMinutes(10);
            if ($now->lt($allowedStartTime)) {
                return [
                    'status' => 'failed',
                    'message' => 'Absensi ditolak: Belum waktunya absen masuk. Pintu absen masuk dibuka jam ' . $allowedStartTime->format('H:i') . ' WIB.'
                ];
            }
        } elseif ($type === 'pulang') {
            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $closestOffice->end_time);
            if ($now->lt($endTime)) {
                return [
                    'status' => 'failed',
                    'message' => 'Absensi ditolak: Belum waktunya absen pulang. Pintu absen pulang dibuka jam ' . $endTime->format('H:i') . ' WIB.'
                ];
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
                return [
                    'status' => 'failed',
                    'message' => 'Absensi ditolak: Belum waktunya sholat ' . ucfirst($type) . ' (' . $prayerTimes[$type] . ' WIB).'
                ];
            }
        }

        if ($minDistance > $maxRadius) {
            // Out of bounds log
            AttendanceLog::create([
                'user_id' => $userId,
                'type' => $type,
                'latitude' => $lat,
                'longitude' => $lon,
                'distance_to_office' => $minDistance,
                'face_matching_score' => null,
                'status' => 'failed',
                'error_message' => 'Di luar radius kantor (' . round($minDistance, 1) . 'm dari ' . $closestOffice->name . ').',
                'snapshot_path' => $snapshotPath,
            ]);

            return [
                'status' => 'failed',
                'message' => 'Absensi ditolak: Anda berada di luar radius kantor (' . round($minDistance, 1) . ' meter).'
            ];
        }

        // 2. Face Recognition Validation (Cosine Similarity on landmark descriptors)
        $storedDescriptor = $user->face_descriptor;

        // Handle dimension mismatch (e.g. old face-api descriptors vs new MediaPipe descriptors)
        if (count($realtimeDescriptor) !== count($storedDescriptor)) {
            AttendanceLog::create([
                'user_id' => $userId,
                'type' => $type,
                'latitude' => $lat,
                'longitude' => $lon,
                'distance_to_office' => $minDistance,
                'face_matching_score' => null,
                'status' => 'failed',
                'error_message' => 'Format wajah tidak kompatibel. Silakan daftarkan ulang wajah Anda.',
                'snapshot_path' => $snapshotPath,
            ]);

            return [
                'status' => 'failed',
                'message' => 'Format wajah tidak kompatibel. Silakan daftarkan ulang wajah Anda di menu profil.'
            ];
        }

        $matchingScore = $this->calculateCosineSimilarity($realtimeDescriptor, $storedDescriptor);

        if ($matchingScore < 0.85) {
            // Rejected face matching (cosine similarity below threshold)
            AttendanceLog::create([
                'user_id' => $userId,
                'type' => $type,
                'latitude' => $lat,
                'longitude' => $lon,
                'distance_to_office' => $minDistance,
                'face_matching_score' => $matchingScore,
                'status' => 'failed',
                'error_message' => 'Wajah tidak cocok (Score: ' . round($matchingScore, 3) . ').',
                'snapshot_path' => $snapshotPath,
            ]);

            return [
                'status' => 'failed',
                'message' => 'Absensi ditolak: Wajah tidak terverifikasi cocok.'
            ];
        }

        // 3. Success
        // Save check-in/out record
        $attendance = Attendance::create([
            'user_id' => $userId,
            'office_id' => $closestOffice->id,
            'type' => $type,
            'date' => today()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'latitude' => $lat,
            'longitude' => $lon,
            'matching_score' => $matchingScore,
            'snapshot_path' => $snapshotPath,
        ]);

        // Log success
        AttendanceLog::create([
            'user_id' => $userId,
            'type' => $type,
            'latitude' => $lat,
            'longitude' => $lon,
            'distance_to_office' => $minDistance,
            'face_matching_score' => $matchingScore,
            'status' => 'success',
            'error_message' => null,
            'snapshot_path' => $snapshotPath,
        ]);

        return [
            'status' => 'success',
            'matching_score' => $matchingScore,
            'distance' => $minDistance,
            'office_name' => $closestOffice->name,
            'attendance' => $attendance,
        ];
    }

    /**
     * Cosine Similarity: measures angle between two vectors.
     * Returns a value between -1 and 1 where 1 = identical.
     * More robust than Euclidean distance for high-dimensional landmark descriptors.
     */
    protected function calculateCosineSimilarity(array $descriptor1, array $descriptor2): float
    {
        if (count($descriptor1) !== count($descriptor2)) {
            throw new \InvalidArgumentException("Descriptors must have the same dimension (" . count($descriptor1) . " vs " . count($descriptor2) . ").");
        }

        $dotProduct = 0.0;
        $norm1 = 0.0;
        $norm2 = 0.0;

        for ($i = 0; $i < count($descriptor1); $i++) {
            $a = (float)$descriptor1[$i];
            $b = (float)$descriptor2[$i];
            $dotProduct += $a * $b;
            $norm1 += $a * $a;
            $norm2 += $b * $b;
        }

        $denominator = sqrt($norm1) * sqrt($norm2);
        if ($denominator == 0) {
            return 0.0;
        }

        return $dotProduct / $denominator;
    }
}
