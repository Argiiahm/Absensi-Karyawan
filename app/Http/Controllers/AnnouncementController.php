<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $announcements = Announcement::with('creator')->orderBy('created_at', 'desc')->get();

        // Mark announcements as read
        $latestId = Announcement::max('id');
        if ($latestId && $latestId > $user->last_read_announcement_id) {
            $user->update([
                'last_read_announcement_id' => $latestId,
            ]);
        }

        return view('components.features.employes.informations.index', compact('announcements'));
    }
}
