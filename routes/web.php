<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['verified', 'role:admin|hrd|karyawan'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::middleware('role:admin|hrd')->group(function () {
            Route::prefix('master')->group(function () {
                Route::resource('divisions', \App\Http\Controllers\DivisionController::class);
                Route::resource('positions', \App\Http\Controllers\PositionController::class);

                Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
            });

            Route::get('attendances', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendances.index');

            Route::prefix('payroll')->group(function () {
                Route::resource('salary-components', \App\Http\Controllers\SalaryComponentController::class)->parameters(['salary-components' => 'salary_component']);
                Route::get('runs', [\App\Http\Controllers\PayrollRunController::class, 'index'])->name('payroll.runs');
                Route::post('runs', [\App\Http\Controllers\PayrollRunController::class, 'store'])->name('payroll.runs.store');
                Route::get('runs/{run}', [\App\Http\Controllers\PayrollRunController::class, 'show'])->name('payroll.show');
                Route::post('runs/{run}/finalize', [\App\Http\Controllers\PayrollRunController::class, 'finalize'])->name('payroll.runs.finalize');
                Route::delete('runs/{run}', [\App\Http\Controllers\PayrollRunController::class, 'destroy'])->name('payroll.runs.destroy');
            });

            Route::prefix('reports')->group(function () {
                Route::get('attendance', [\App\Http\Controllers\ReportController::class, 'attendance'])->name('reports.attendance');
                Route::get('payroll', [\App\Http\Controllers\ReportController::class, 'payroll'])->name('reports.payroll');
            });

            Route::get('leaves', [\App\Http\Controllers\LeaveRequestController::class, 'index'])->name('leaves.index');
            Route::patch('leaves/{leave}/approve', [\App\Http\Controllers\LeaveRequestController::class, 'approve'])->name('leaves.approve');
        });

        Route::middleware('role:admin')->prefix('settings')->group(function () {
            Route::view('work', 'settings.work')->name('settings.work');
        });

        Route::middleware('role:admin|hrd')->prefix('settings')->group(function () {
            Route::resource('holidays', \App\Http\Controllers\HolidayController::class)->only(['index', 'store', 'update', 'destroy']);
        });

        Route::middleware('role:karyawan')->group(function () {
            Route::get('attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'checkinForm'])->name('attendances.checkin');
            Route::post('attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'storeCheckin'])->name('attendances.store');
            Route::get('attendance/history', [\App\Http\Controllers\AttendanceController::class, 'history'])->name('attendances.history');
            Route::get('payroll/slip', [\App\Http\Controllers\PayrollController::class, 'slip'])->name('payroll.slip');
            Route::get('leaves/my', [\App\Http\Controllers\LeaveRequestController::class, 'myLeaves'])->name('leaves.my');
            Route::post('leaves', [\App\Http\Controllers\LeaveRequestController::class, 'store'])->name('leaves.store');
            Route::delete('leaves/{leave}', [\App\Http\Controllers\LeaveRequestController::class, 'destroy'])->name('leaves.destroy');
        });
        
        // This can be accessed by both admin and karyawan, assuming the controller authorizes it
        Route::get('payroll/{payroll}/slip/pdf', [\App\Http\Controllers\PayrollController::class, 'downloadPdf'])->name('payroll.slip.pdf');
    });
});

require __DIR__.'/auth.php';
