<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of all attendances (Admin/HRD).
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee')->latest('work_date')->latest('check_in_at');
        
        // Optional filtering by date can be added here later
        
        $attendances = $query->paginate(15);
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $stats = [
            'present' => Attendance::whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'present')
                ->count(),
            'permit' => Attendance::whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'izin')
                ->count(),
            'sick' => Attendance::whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'sakit')
                ->count(),
            'absent' => Attendance::whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'alpha')
                ->count(),
        ];
        
        return view('attendances.index', compact('attendances', 'stats'));
    }

    /**
     * Show Karyawan's own attendance history.
     */
    public function history()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        if (!$employee) {
            abort(403, 'Anda belum terdaftar sebagai karyawan.');
        }

        $attendances = Attendance::where('employee_id', $employee->id)
                                 ->latest('work_date')
                                 ->paginate(15);

        return view('attendances.history', compact('attendances'));
    }

    /**
     * Show check-in form.
     */
    public function checkinForm()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        if (!$employee) {
            abort(403, 'Anda belum terdaftar sebagai karyawan.');
        }

        $today = Carbon::today();
        
        // Find if already checked in today
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('work_date', $today)
                                ->first();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $stats = [
            'present' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'present')
                ->count(),
            'permit' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'izin')
                ->count(),
            'sick' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'sakit')
                ->count(),
            'absent' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)
                ->whereYear('work_date', $currentYear)
                ->where('status', 'alpha')
                ->count(),
        ];

        return view('attendances.checkin', compact('attendance', 'stats'));
    }

    /**
     * Store check-in or check-out.
     */
    public function storeCheckin(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        if (!$employee) {
            abort(403, 'Anda belum terdaftar sebagai karyawan.');
        }

        $now = Carbon::now();
        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('work_date', $today)
                                ->first();

        // Check if action is Check In or Check Out based on existing record
        if (!$attendance) {
            // Check In
            // Simple logic for late minutes: assume work starts at 08:00
            $workStartTime = Carbon::today()->setHour(8)->setMinute(0)->setSecond(0);
            $lateMinutes = 0;
            if ($now->greaterThan($workStartTime)) {
                $lateMinutes = (int) abs($now->diffInMinutes($workStartTime));
            }
            
            $status = 'present';

            Attendance::create([
                'employee_id' => $employee->id,
                'work_date' => $today,
                'check_in_at' => $now,
                'status' => $status,
                'late_minutes' => $lateMinutes,
            ]);

            return redirect()->route('attendances.checkin')->with('status', 'Berhasil Check-in pada ' . $now->format('H:i'));

        } else if (!$attendance->check_out_at) {
            // Check Out
            $attendance->update([
                'check_out_at' => $now,
            ]);

            return redirect()->route('attendances.checkin')->with('status', 'Berhasil Check-out pada ' . $now->format('H:i'));
        }

        return redirect()->route('attendances.checkin')->withErrors('Anda sudah menyelesaikan absensi hari ini.');
    }
}
