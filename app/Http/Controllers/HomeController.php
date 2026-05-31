<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Office;
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

        return view('components.features.employes.home.home', compact('user', 'hasCheckedIn', 'hasCheckedOut', 'office'));
    }
}
