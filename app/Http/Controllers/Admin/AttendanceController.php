<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = User::where('role', '!=', 'admin');

        // Search name
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter by dynamic status
        if ($statusFilter === 'tidak_masuk') {
            $query->whereDoesntHave('attendances', function ($q) use ($date) {
                $q->whereDate('date', $date)->where('type', 'masuk');
            });
        } elseif ($statusFilter === 'tepat_waktu') {
            $query->whereHas('attendances', function ($q) use ($date) {
                $q->whereDate('date', $date)
                  ->where('type', 'masuk')
                  ->where(function ($sub) {
                      $sub->whereRaw('time <= (select start_time from offices where offices.id = attendances.office_id)')
                          ->orWhereNull('office_id');
                  });
            });
        } elseif ($statusFilter === 'terlambat') {
            $query->whereHas('attendances', function ($q) use ($date) {
                $q->whereDate('date', $date)
                  ->where('type', 'masuk')
                  ->whereRaw('time > (select start_time from offices where offices.id = attendances.office_id)');
            });
        }

        // Eager load attendances for the selected date
        $query->with(['attendances' => function ($q) use ($date) {
            $q->whereDate('date', $date)->with('office');
        }]);

        $users = $query->paginate(20)->withQueryString();

        // Transform users to add attendance state
        $users->getCollection()->transform(function ($user) use ($date) {
            $todayAttendances = $user->attendances;
            $masuk = $todayAttendances->where('type', 'masuk')->first();
            $pulang = $todayAttendances->where('type', 'pulang')->first();

            $status = 'tidak_masuk'; // default
            $timeLabel = '-';
            $pulangTimeLabel = '-';
            $officeName = '-';
            $snapshotPath = null;
            $attendanceId = null;

            if ($masuk) {
                $office = $masuk->office;
                $officeStartTime = $office ? $office->start_time : '07:00:00';
                $isLate = \Carbon\Carbon::parse($masuk->time)->gt(\Carbon\Carbon::parse($officeStartTime));
                
                $status = $isLate ? 'terlambat' : 'tepat_waktu';
                $timeLabel = \Carbon\Carbon::parse($masuk->time)->format('H:i') . ' WIB';
                $officeName = $office ? $office->name : '-';
                $snapshotPath = $masuk->snapshot_path;
                $attendanceId = $masuk->id;
            }

            if ($pulang) {
                $pulangTimeLabel = \Carbon\Carbon::parse($pulang->time)->format('H:i') . ' WIB';
                if (!$attendanceId) {
                    $attendanceId = $pulang->id;
                }
            }

            $user->computed_attendance = (object)[
                'status' => $status,
                'time_masuk' => $timeLabel,
                'time_pulang' => $pulangTimeLabel,
                'office_name' => $officeName,
                'snapshot_path' => $snapshotPath,
                'attendance_id' => $attendanceId,
            ];

            return $user;
        });

        return view('components.features.admin.attendances.index', compact('users'));
    }

    public function show($id)
    {
        // Eager load all relations for the detail page → no N+1
        $attendance = Attendance::with(['user', 'office'])->findOrFail($id);

        return view('components.features.admin.attendances.show', compact('attendance'));
    }

    public function prayers(Request $request)
    {
        $query = Attendance::with(['user', 'office'])
            ->whereIn('type', ['subuh', 'zuhur', 'asar', 'maghrib', 'isya']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', today());
        }

        // Filter by prayer type (waktu sholat)
        if ($request->filled('prayer')) {
            $query->where('type', $request->prayer);
        }

        // Filter by search (name)
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->latest('id')->paginate(20)->withQueryString();

        return view('components.features.admin.attendances.prayers', compact('attendances'));
    }
}
