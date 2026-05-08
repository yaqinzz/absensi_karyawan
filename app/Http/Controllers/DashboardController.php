<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin') || $user->hasRole('hrd')) {
            $today = \Carbon\Carbon::today();
            $currentMonth = \Carbon\Carbon::now()->month;
            
            // Calculate monthly summary for Izin and Sakit
            $monthSakit = \App\Models\LeaveRequest::where('status', 'approved')
                ->where('leave_type', 'sick')
                ->where(function($q) use ($currentMonth) {
                    $q->whereMonth('start_date', $currentMonth)->orWhereMonth('end_date', $currentMonth);
                })->get();
            
            $monthIzin = \App\Models\LeaveRequest::where('status', 'approved')
                ->where('leave_type', '!=', 'sick')
                ->where(function($q) use ($currentMonth) {
                    $q->whereMonth('start_date', $currentMonth)->orWhereMonth('end_date', $currentMonth);
                })->get();

            $totalMonthSakit = 0;
            foreach ($monthSakit as $leave) {
                $cur = $leave->start_date->copy();
                while ($cur->lte($leave->end_date)) {
                    if ($cur->month == $currentMonth && $cur->isWeekday()) $totalMonthSakit++;
                    $cur->addDay();
                }
            }

            $totalMonthIzin = 0;
            foreach ($monthIzin as $leave) {
                $cur = $leave->start_date->copy();
                while ($cur->lte($leave->end_date)) {
                    if ($cur->month == $currentMonth && $cur->isWeekday()) $totalMonthIzin++;
                    $cur->addDay();
                }
            }

            $stats = [
                'employee_count' => \App\Models\Employee::where('status', 'active')->count(),
                'today_present' => \App\Models\Attendance::where('work_date', $today)->where('status', 'present')->count(),
                'today_sakit' => \App\Models\Attendance::where('work_date', $today)->where('status', 'sakit')->count() + 
                                \App\Models\LeaveRequest::where('status', 'approved')
                                    ->where('leave_type', 'sick')
                                    ->where('start_date', '<=', $today->toDateString())
                                    ->where('end_date', '>=', $today->toDateString())
                                    ->count(),
                'today_izin' => \App\Models\Attendance::where('work_date', $today)->where('status', 'izin')->count() + 
                               \App\Models\LeaveRequest::where('status', 'approved')
                                   ->where('leave_type', '!=', 'sick')
                                   ->where('start_date', '<=', $today->toDateString())
                                   ->where('end_date', '>=', $today->toDateString())
                                   ->count(),
                'month_sakit' => $totalMonthSakit,
                'month_izin'  => $totalMonthIzin,
                'draft_payrolls' => \App\Models\PayrollRun::where('status', 'draft')->count(),
                'total_payroll_month' => \App\Models\Payroll::whereHas('run', function($q) use ($currentMonth) {
                    $q->whereMonth('period_start', $currentMonth);
                })->sum('net_pay'),
            ];

            // Calculation for Absensi Hari Ini %
            $todayNotAbsent = $stats['today_present'] + $stats['today_sakit'] + $stats['today_izin'];
            $attendancePercentage = $stats['employee_count'] > 0 
                ? round(($todayNotAbsent / $stats['employee_count']) * 100) 
                : 0;
            $stats['attendance_percentage'] = min(100, $attendancePercentage);

            $recent_employees = \App\Models\Employee::with(['division', 'position'])->latest()->take(3)->get();
            $recent_attendances = \App\Models\Attendance::with('employee')->latest('check_in_at')->take(5)->get();

            if ($user->hasRole('admin')) {
                return view('dashboards.admin', compact('stats', 'recent_employees', 'recent_attendances'));
            }
            return view('dashboards.hrd', compact('stats', 'recent_employees', 'recent_attendances'));
        }

        if ($user->hasRole('karyawan')) {
            $employee = $user->employee;
            if (!$employee) {
                abort(403, 'Anda belum terdaftar sebagai karyawan.');
            }

            $today = \Carbon\Carbon::today();
            $attendance = \App\Models\Attendance::where('employee_id', $employee->id)
                                    ->where('work_date', $today)
                                    ->first();

            $currentMonth = \Carbon\Carbon::now()->month;
            $currentYear = \Carbon\Carbon::now()->year;

            // Attendance Table counts
            $attPresent = \App\Models\Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)->whereYear('work_date', $currentYear)
                ->where('status', 'present')->count();
            
            $attLate = \App\Models\Attendance::where('employee_id', $employee->id)
                ->whereMonth('work_date', $currentMonth)->whereYear('work_date', $currentYear)
                ->where('late_minutes', '>', 0)->count();

            // Approved Leave counts
            $approvedLeaves = \App\Models\LeaveRequest::where('employee_id', $employee->id)
                ->where('status', 'approved')
                ->where(function($q) use ($currentMonth, $currentYear) {
                    $q->whereMonth('start_date', $currentMonth)->whereYear('start_date', $currentYear)
                      ->orWhereMonth('end_date', $currentMonth)->whereYear('end_date', $currentYear);
                })->get();

            $leaveSakit = 0;
            $leaveIzin = 0;

            foreach ($approvedLeaves as $leave) {
                // We need to count days within the current month
                $start = $leave->start_date->copy()->startOfMonth();
                if ($leave->start_date->month == $currentMonth && $leave->start_date->year == $currentYear) {
                    $start = $leave->start_date;
                }
                
                $end = $leave->end_date->copy()->endOfMonth();
                if ($leave->end_date->month == $currentMonth && $leave->end_date->year == $currentYear) {
                    $end = $leave->end_date;
                }

                $days = 0;
                $cur = $start->copy();
                while ($cur->lte($end)) {
                    if ($cur->month == $currentMonth && $cur->year == $currentYear && $cur->isWeekday()) {
                        $days++;
                    }
                    $cur->addDay();
                }

                if ($leave->leave_type === 'sick') {
                    $leaveSakit += $days;
                } else {
                    // annual, unpaid, other are counted as 'izin'
                    $leaveIzin += $days;
                }
            }

            $stats = [
                'present' => $attPresent,
                'permit'  => $leaveIzin,
                'sick'    => $leaveSakit,
                'late'    => $attLate,
            ];

            $recent_attendances = \App\Models\Attendance::where('employee_id', $employee->id)
                                                        ->latest('work_date')
                                                        ->take(5)
                                                        ->get();

            $latest_payroll = \App\Models\Payroll::where('employee_id', $employee->id)
                                                 ->latest('created_at')
                                                 ->first();

            return view('dashboards.karyawan', compact('attendance', 'stats', 'recent_attendances', 'latest_payroll'));
        }

        abort(403);
    }
}
