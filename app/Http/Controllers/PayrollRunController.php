<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollRun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollRunController extends Controller
{
    public function index()
    {
        $runs = PayrollRun::latest('period_start')->paginate(10);
        return view('payroll.runs', compact('runs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'period_month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->period_month);
        $periodStart = $month->copy()->startOfMonth();
        $periodEnd = $month->copy()->endOfMonth();
        $payDate = $periodEnd->copy();

        // Check if run already exists for this period
        $existing = PayrollRun::where('period_start', $periodStart)->first();
        if ($existing) {
            return redirect()->back()->withErrors('Payroll untuk periode ini sudah ada.');
        }

        DB::beginTransaction();
        try {
            $run = PayrollRun::create([
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'pay_date' => $payDate,
                'status' => 'draft',
                'created_by' => Auth::id(),
            ]);

            // Ambil semua komponen gaji yang aktif secara global
            $activeComponents = \App\Models\SalaryComponent::where('is_active', true)->get();

            // Generate payroll for all active employees
            $employees = Employee::where('status', 'active')->get();
            foreach ($employees as $emp) {
                $baseSalary = $emp->base_salary ?? 0;
                $totalEarnings = 0;
                $totalDeductions = 0;

                // Ambil data kehadiran karyawan pada periode ini
                $attendances = \App\Models\Attendance::where('employee_id', $emp->id)
                    ->whereBetween('work_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
                    ->get();

                // Ambil tanggal hari libur dalam periode (nasional + kantor)
                $holidayDates = \App\Models\Holiday::whereBetween('date', [$periodStart->toDateString(), $periodEnd->toDateString()])
                    ->pluck('date')
                    ->map(fn($d) => $d->toDateString())
                    ->toArray();

                // Hitung hari kerja efektif (Senin-Jumat) MINUS hari libur
                $workDays = 0;
                $current = $periodStart->copy();
                while ($current->lte($periodEnd)) {
                    if ($current->isWeekday() && !in_array($current->toDateString(), $holidayDates)) {
                        $workDays++;
                    }
                    $current->addDay();
                }

                $presentDays  = $attendances->where('status', 'present')->count();

                // Hari cuti yang disetujui (paid leave) tidak dihitung absen
                $approvedLeaves = \App\Models\LeaveRequest::where('employee_id', $emp->id)
                    ->where('status', 'approved')
                    ->where('leave_type', '!=', 'unpaid')  // cuti tanpa bayar tetap dipotong
                    ->where('start_date', '<=', $periodEnd->toDateString())
                    ->where('end_date', '>=', $periodStart->toDateString())
                    ->get();

                $leaveDays = 0;
                foreach ($approvedLeaves as $leave) {
                    $leaveStart = $leave->start_date->max($periodStart);
                    $leaveEnd   = $leave->end_date->min($periodEnd);
                    $cur = $leaveStart->copy();
                    while ($cur->lte($leaveEnd)) {
                        if ($cur->isWeekday() && !in_array($cur->toDateString(), $holidayDates)) {
                            $leaveDays++;
                        }
                        $cur->addDay();
                    }
                }

                // Cuti tanpa bayar → tetap potong gaji tapi tidak masuk hitungan absen
                $unpaidLeaveDays = 0;
                $unpaidLeaves = \App\Models\LeaveRequest::where('employee_id', $emp->id)
                    ->where('status', 'approved')
                    ->where('leave_type', 'unpaid')
                    ->where('start_date', '<=', $periodEnd->toDateString())
                    ->where('end_date', '>=', $periodStart->toDateString())
                    ->get();

                foreach ($unpaidLeaves as $leave) {
                    $leaveStart = $leave->start_date->max($periodStart);
                    $leaveEnd   = $leave->end_date->min($periodEnd);
                    $cur = $leaveStart->copy();
                    while ($cur->lte($leaveEnd)) {
                        if ($cur->isWeekday() && !in_array($cur->toDateString(), $holidayDates)) {
                            $unpaidLeaveDays++;
                        }
                        $cur->addDay();
                    }
                }

                $absentDays   = max(0, $workDays - $presentDays - $leaveDays - $unpaidLeaveDays);
                $totalLateMin = $attendances->sum('late_minutes');

                // Potongan proporsional cuti tanpa bayar: gaji_harian × hari_unpaid
                // Gaji harian = base_salary / workDays (hari kerja efektif bulan ini)
                $unpaidDeduction = 0;
                if ($unpaidLeaveDays > 0 && $workDays > 0) {
                    $dailySalary     = $baseSalary / $workDays;
                    $unpaidDeduction = round($dailySalary * $unpaidLeaveDays, 2);
                }

                $payroll = Payroll::create([
                    'payroll_run_id' => $run->id,
                    'employee_id'    => $emp->id,
                    'base_salary'    => $baseSalary,
                    'total_earnings' => 0,
                    'total_deductions' => 0,
                    'net_pay'        => 0,
                ]);

                foreach ($activeComponents as $comp) {
                    $amount = 0;

                    // Komponen khusus: hitung dari data kehadiran nyata
                    if ($comp->code === 'ABSENT') {
                        $penaltyPerDay = $comp->default_amount > 0 ? $comp->default_amount : 150000;
                        $amount = $absentDays * $penaltyPerDay;
                    } elseif ($comp->code === 'LATE') {
                        $penaltyPerMin = $comp->default_amount > 0 ? $comp->default_amount : 2000;
                        $amount = $totalLateMin * $penaltyPerMin;
                    } elseif ($comp->is_percentage) {
                        $amount = round(($baseSalary * $comp->default_amount) / 100, 2);
                    } else {
                        $amount = $comp->default_amount;
                    }

                    if ($amount == 0 && in_array($comp->code, ['ABSENT', 'LATE'])) {
                        // Skip jika tidak ada potongan (tidak perlu item dengan nilai 0)
                        continue;
                    }

                    if ($comp->type === 'allowance') {
                        $totalEarnings += $amount;
                    } else {
                        $totalDeductions += $amount;
                    }

                    \App\Models\PayrollItem::create([
                        'payroll_id'          => $payroll->id,
                        'salary_component_id' => $comp->id,
                        'name'                => $comp->name,
                        'type'                => $comp->type,
                        'amount'              => $amount,
                    ]);
                }

                // Tambahkan potongan cuti tanpa bayar (proporsional) sebagai payroll item
                if ($unpaidDeduction > 0) {
                    $totalDeductions += $unpaidDeduction;
                    \App\Models\PayrollItem::create([
                        'payroll_id'          => $payroll->id,
                        'salary_component_id' => null,
                        'name'                => "Cuti Tanpa Bayar ({$unpaidLeaveDays} hari)",
                        'type'                => 'deduction',
                        'amount'              => $unpaidDeduction,
                    ]);
                }

                $netPay = $baseSalary + $totalEarnings - $totalDeductions;

                $payroll->update([
                    'total_earnings'   => $totalEarnings,
                    'total_deductions' => $totalDeductions,
                    'net_pay'          => $netPay,
                ]);
            }

            DB::commit();
            return redirect()->route('payroll.runs')->with('status', 'Payroll Run berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal membuat payroll: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $run = PayrollRun::findOrFail($id);
        $payrolls = Payroll::where('payroll_run_id', $run->id)->with('employee')->paginate(20);
        
        return view('payroll.show', compact('run', 'payrolls'));
    }

    public function finalize($id)
    {
        $run = PayrollRun::findOrFail($id);
        
        if ($run->status === 'final') {
            return redirect()->back()->withErrors('Payroll sudah difinalisasi.');
        }

        $run->update(['status' => 'final']);

        return redirect()->back()->with('status', 'Payroll berhasil difinalisasi.');
    }

    public function destroy($id)
    {
        $run = PayrollRun::findOrFail($id);

        if ($run->status === 'final') {
            return redirect()->back()->withErrors('Payroll yang sudah final tidak bisa dihapus.');
        }

        DB::beginTransaction();
        try {
            Payroll::where('payroll_run_id', $run->id)->delete();
            $run->delete();

            DB::commit();
            return redirect()->route('payroll.runs')->with('status', 'Draft Payroll berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal menghapus payroll: ' . $e->getMessage());
        }
    }
}
