<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $attendances = Attendance::with('office')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->locale('id')->isoFormat('dddd, D MMMM Y');
            });

        return view('components.features.employes.history.history', compact('attendances'));
    }
}
