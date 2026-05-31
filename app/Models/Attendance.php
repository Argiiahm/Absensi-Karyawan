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
}
