<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'latitude'  => 'double',
        'longitude' => 'double',
        'radius'    => 'integer',
    ];

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }
}
