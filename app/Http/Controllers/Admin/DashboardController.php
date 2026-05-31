<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total karyawan (role bukan admin)
        $totalEmployees = User::where('role', '!=', 'admin')->count();

        // Hadir hari ini (yang sudah absen masuk)
        $presentToday = Attendance::whereDate('date', today())
            ->where('type', 'masuk')
            ->distinct('user_id')
            ->count('user_id');

        // Terlambat hari ini (absen masuk setelah jam 09:00)
        $lateToday = Attendance::whereDate('date', today())
            ->where('type', 'masuk')
            ->whereTime('time', '>', '09:00:00')
            ->distinct('user_id')
            ->count('user_id');

        // Persentase kehadiran bulan ini
        $month          = Carbon::now()->month;
        $year           = Carbon::now()->year;
        $workingDays    = $this->getWorkingDaysThisMonth();
        $presentDays    = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('type', 'masuk')
            ->distinct('user_id', 'date')
            ->count();
        $presentPercent = $totalEmployees > 0 && $workingDays > 0
            ? round(($presentDays / ($totalEmployees * $workingDays)) * 100)
            : 0;
        $presentPercent = min(100, $presentPercent);

        // 5 aktivitas absensi terbaru (eager load user + office → no N+1)
        $recentAttendances = Attendance::with(['user', 'office'])
            ->latest()
            ->take(5)
            ->get();

        // Statistik bulan ini
        $onTimeDays = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('type', 'masuk')
            ->whereTime('time', '<=', '09:00:00')
            ->count();

        $lateDays = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('type', 'masuk')
            ->whereTime('time', '>', '09:00:00')
            ->count();

        return view('components.features.admin.dashboard.index', compact(
            'totalEmployees',
            'presentToday',
            'lateToday',
            'presentPercent',
            'recentAttendances',
            'onTimeDays',
            'lateDays'
        ));
    }

    /**
     * Count working days (Mon–Sat) in the current month up to today.
     */
    private function getWorkingDaysThisMonth(): int
    {
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now();
        $days  = 0;

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            // Monday (1) to Saturday (6)
            if ($d->dayOfWeek !== Carbon::SUNDAY) {
                $days++;
            }
        }

        return max(1, $days);
    }
}
