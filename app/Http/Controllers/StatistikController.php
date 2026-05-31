<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Month navigation: default to current month
        $month = (int) $request->get('month', Carbon::now()->month);
        $year  = (int) $request->get('year',  Carbon::now()->year);

        $carbonDate  = Carbon::createFromDate($year, $month, 1);
        $monthLabel  = $carbonDate->locale('id')->isoFormat('MMMM Y');
        $prevMonth   = $carbonDate->copy()->subMonth();
        $nextMonth   = $carbonDate->copy()->addMonth();
        $isThisMonth = ($month === Carbon::now()->month && $year === Carbon::now()->year);

        // Get all check-ins for the month (single query, no N+1)
        $checkIns = Attendance::where('user_id', $userId)
            ->where('type', 'masuk')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // Working days this month (Mon–Sat) up to today if current month
        $endDate   = $isThisMonth ? Carbon::now() : $carbonDate->copy()->endOfMonth();
        $workingDays = $this->countWorkingDays($carbonDate->copy()->startOfMonth(), $endDate);

        // Stats
        $hadir      = $checkIns->count();
        $tepat      = $checkIns->filter(fn($a) => Carbon::parse($a->time)->lte(Carbon::parse('09:00:00')))->count();
        $telat      = $hadir - $tepat;
        $persentase = $workingDays > 0 ? min(100, round(($hadir / $workingDays) * 100)) : 0;

        return view('components.features.employes.Statistik.statistik', compact(
            'hadir',
            'tepat',
            'telat',
            'persentase',
            'workingDays',
            'monthLabel',
            'month',
            'year',
            'prevMonth',
            'nextMonth',
            'isThisMonth'
        ));
    }

    private function countWorkingDays(Carbon $start, Carbon $end): int
    {
        $days = 0;
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            if ($d->dayOfWeek !== Carbon::SUNDAY) {
                $days++;
            }
        }
        return max(1, $days);
    }
}
