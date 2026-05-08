<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Division;
use App\Models\Payroll;
use App\Models\PayrollRun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function attendance(Request $request)
    {
        $periodMonth = $request->get('period_month', Carbon::now()->format('Y-m'));
        $divisionId = $request->get('division_id', 'all');

        $month = Carbon::createFromFormat('Y-m', $periodMonth);
        $divisions = Division::all();

        $query = Division::query();
        if ($divisionId !== 'all') {
            $query->where('id', $divisionId);
        }
        
        $reportData = $query->get()->map(function($division) use ($month) {
            $employeeIds = $division->employees()->pluck('id');
            
            $attendances = Attendance::whereIn('employee_id', $employeeIds)
                                     ->whereMonth('work_date', $month->month)
                                     ->whereYear('work_date', $month->year)
                                     ->get();

            return [
                'division_name' => $division->name,
                'present' => $attendances->where('status', 'present')->count(),
                'permit' => $attendances->where('status', 'izin')->count(),
                'sick' => $attendances->where('status', 'sakit')->count(),
                'absent' => $attendances->where('status', 'alpha')->count(),
                'late' => $attendances->where('late_minutes', '>', 0)->count(),
            ];
        });

        return view('reports.attendance', compact('reportData', 'divisions', 'periodMonth', 'divisionId'));
    }

    public function payroll(Request $request)
    {
        $periodMonth = $request->get('period_month', Carbon::now()->format('Y-m'));
        $divisionId = $request->get('division_id', 'all');

        $month = Carbon::createFromFormat('Y-m', $periodMonth);
        $divisions = Division::all();

        $run = PayrollRun::whereMonth('period_start', $month->month)
                         ->whereYear('period_start', $month->year)
                         ->first();

        $reportData = collect();

        if ($run) {
            $query = Division::query();
            if ($divisionId !== 'all') {
                $query->where('id', $divisionId);
            }

            $reportData = $query->get()->map(function($division) use ($run) {
                $employeeIds = $division->employees()->pluck('id');
                
                $payrolls = Payroll::where('payroll_run_id', $run->id)
                                   ->whereIn('employee_id', $employeeIds)
                                   ->get();

                return [
                    'division_name' => $division->name,
                    'total_earnings' => $payrolls->sum(function($p) { return $p->base_salary + $p->total_earnings; }),
                    'total_deductions' => $payrolls->sum('total_deductions'),
                    'net_pay' => $payrolls->sum('net_pay'),
                    'employee_count' => $payrolls->count(),
                ];
            });
        }

        return view('reports.payroll', compact('reportData', 'divisions', 'periodMonth', 'divisionId', 'run'));
    }
}
