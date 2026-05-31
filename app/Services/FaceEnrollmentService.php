<?php

namespace App\Services;

use App\Models\User;

class FaceEnrollmentService
{
    public function enroll(int $userId, array $faceDescriptor): bool
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        // Only save face descriptor (no reference photo saved on disk/db)
        return $user->update([
            'face_descriptor' => $faceDescriptor,
            'face_photo_path' => null,
            'is_face_enrolled' => true,
        ]);
    }
}
