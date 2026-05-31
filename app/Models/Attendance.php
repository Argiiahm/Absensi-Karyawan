<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id',
        'type',
        'date',
        'time',
        'latitude',
        'longitude',
        'matching_score',
        'snapshot_path',
    ];

    protected $casts = [
        'date' => 'date',
        'latitude' => 'double',
        'longitude' => 'double',
        'matching_score' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function getDistanceToOfficeAttribute()
    {
        if (!$this->office) {
            return null;
        }

        $lat1 = (float)$this->latitude;
        $lon1 = (float)$this->longitude;
        $lat2 = (float)$this->office->latitude;
        $lon2 = (float)$this->office->longitude;

        $earthRadius = 6371000; // in meters
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
