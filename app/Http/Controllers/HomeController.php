<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Office;
use App\Models\Leave;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Eager load 'office' to prevent N+1 queries in the view
        $todayAttendance = Attendance::with('office')
            ->where('user_id', $user->id)
            ->whereDate('date', today())
            ->get();

        $hasCheckedIn = $todayAttendance->where('type', 'masuk')->first();
        $hasCheckedOut = $todayAttendance->where('type', 'pulang')->first();
        $office = Office::first();

        // Check if there is an approved leave for today
        $todayLeave = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->first();

        // Check if there are unread announcements
        $latestAnnouncementId = Announcement::max('id') ?? 0;
        $hasUnreadAnnouncement = $latestAnnouncementId > ($user->last_read_announcement_id ?? 0);

        return view('components.features.employes.home.home', compact(
            'user', 
            'hasCheckedIn', 
            'hasCheckedOut', 
            'office', 
            'todayLeave', 
            'hasUnreadAnnouncement'
        ));
    }
}
