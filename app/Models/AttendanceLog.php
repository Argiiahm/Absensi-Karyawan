<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'latitude',
        'longitude',
        'distance_to_office',
        'face_matching_score',
        'status',
        'error_message',
        'snapshot_path',
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'distance_to_office' => 'double',
        'face_matching_score' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
