<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /** HRD/Admin: lihat semua pengajuan */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $leaves = LeaveRequest::with('employee')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('leaves.index', compact('leaves', 'status'));
    }

    /** Karyawan: lihat riwayat cuti sendiri */
    public function myLeaves()
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();
        $leaves   = LeaveRequest::where('employee_id', $employee->id)->latest()->paginate(15);
        return view('leaves.my-leaves', compact('leaves', 'employee'));
    }

    /** Karyawan: simpan pengajuan cuti */
    public function store(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'leave_type' => 'required|in:annual,sick,unpaid,other',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required|string|max:500',
        ]);

        $start = Carbon::parse($data['start_date']);
        $end   = Carbon::parse($data['end_date']);

        // Hitung hari kerja (Senin-Jumat) dalam rentang cuti
        $totalDays = 0;
        $cur = $start->copy();
        while ($cur->lte($end)) {
            if ($cur->isWeekday()) $totalDays++;
            $cur->addDay();
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type'  => $data['leave_type'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'total_days'  => $totalDays,
            'reason'      => $data['reason'],
            'status'      => 'pending',
        ]);

        return redirect()->route('leaves.my')->with('status', 'Pengajuan cuti berhasil dikirim.');
    }

    /** HRD/Admin: approve/reject */
    public function approve(Request $request, LeaveRequest $leave)
    {
        $request->validate([
            'action'         => 'required|in:approved,rejected',
            'approver_notes' => 'nullable|string|max:500',
        ]);

        $leave->update([
            'status'         => $request->action,
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'approver_notes' => $request->approver_notes,
        ]);

        $label = $request->action === 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('status', "Pengajuan cuti berhasil {$label}.");
    }

    /** Karyawan: batalkan pengajuan yang masih pending */
    public function destroy(LeaveRequest $leave)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        if ($leave->employee_id !== $employee->id || $leave->status !== 'pending') {
            abort(403);
        }

        $leave->delete();
        return redirect()->route('leaves.my')->with('status', 'Pengajuan cuti dibatalkan.');
    }
}
