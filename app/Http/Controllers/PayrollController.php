<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Show the latest salary slip for the logged-in employee.
     */
    public function slip()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        if (!$employee) {
            abort(403, 'Anda belum terdaftar sebagai karyawan.');
        }

        // Get the latest payroll for this employee
        $payroll = Payroll::where('employee_id', $employee->id)
                          ->latest('created_at')
                          ->first();

        return view('payroll.slip', compact('payroll'));
    }

    /**
     * Download the salary slip as PDF.
     */
    public function downloadPdf($id)
    {
        $payroll = Payroll::findOrFail($id);
        
        // Ensure user is authorized to download
        $user = Auth::user();
        if ($user->hasRole('karyawan') && $payroll->employee_id !== $user->employee?->id) {
            abort(403, 'Unauthorized access to slip.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payroll.slip_pdf', compact('payroll'));
        
        $filename = 'Slip_Gaji_' . $payroll->employee->name . '_' . $payroll->run->period_start->format('M_Y') . '.pdf';
        
        return $pdf->download($filename);
    }
}
