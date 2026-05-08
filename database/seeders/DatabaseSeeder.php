<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeSalaryComponent;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\PayrollRun;
use App\Models\Position;
use App\Models\SalaryComponent;
use App\Models\User;
use App\Models\WorkSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = collect(['admin', 'hrd', 'karyawan'])
            ->map(fn (string $role) => Role::firstOrCreate(['name' => $role]));

        $admin = User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@company.test',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $hrd = User::factory()->create([
            'name' => 'HRD Utama',
            'email' => 'hrd@company.test',
            'password' => Hash::make('password'),
        ]);
        $hrd->assignRole('hrd');

        $divisions = Division::factory()
            ->count(3)
            ->sequence(
                ['code' => 'DIV-FIN', 'name' => 'Finance'],
                ['code' => 'DIV-HRD', 'name' => 'Human Resource'],
                ['code' => 'DIV-ENG', 'name' => 'Engineering']
            )
            ->create();

        $positions = Position::factory()
            ->count(3)
            ->sequence(
                ['code' => 'POS-MGR', 'name' => 'Manager', 'level' => 4],
                ['code' => 'POS-STF', 'name' => 'Staff', 'level' => 2],
                ['code' => 'POS-ANL', 'name' => 'Analyst', 'level' => 3]
            )
            ->create();

        $workSetting = WorkSetting::create([
            'work_start' => '08:00:00',
            'work_end' => '17:00:00',
            'grace_minutes' => 10,
            'late_penalty_per_minute' => 2000,
            'absence_penalty_per_day' => 150000,
            'bpjs_percent' => 1.0,
            'tax_percent' => 5.0,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $employees = Employee::factory()
            ->count(8)
            ->state(fn () => [
                'division_id' => $divisions->random()->id,
                'position_id' => $positions->random()->id,
            ])
            ->create();

        $employeeUsers = $employees->take(3)->values();
        foreach ($employeeUsers as $index => $employee) {
            $user = User::factory()->create([
                'name' => $employee->name,
                'email' => 'karyawan'.($index + 1).'@company.test',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('karyawan');
            $employee->update(['user_id' => $user->id]);
        }

        $components = collect([
            ['code' => 'BASIC', 'name' => 'Gaji Pokok',    'type' => 'allowance', 'is_fixed' => true,  'default_amount' => 0],
            ['code' => 'ALLOW', 'name' => 'Tunjangan',     'type' => 'allowance', 'is_fixed' => true,  'default_amount' => 500000],
            ['code' => 'BONUS', 'name' => 'Bonus',         'type' => 'allowance', 'is_fixed' => false, 'default_amount' => 0],
            ['code' => 'LATE',  'name' => 'Keterlambatan', 'type' => 'deduction', 'is_fixed' => false, 'default_amount' => 0],
            ['code' => 'ABSENT','name' => 'Ketidakhadiran','type' => 'deduction', 'is_fixed' => false, 'default_amount' => 0],
            ['code' => 'BPJS',  'name' => 'BPJS',          'type' => 'deduction', 'is_fixed' => true,  'default_amount' => 0],
            ['code' => 'TAX',   'name' => 'Pajak',         'type' => 'deduction', 'is_fixed' => true,  'default_amount' => 0],
        ])->map(function (array $data) {
            return SalaryComponent::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['is_active' => true])
            );
        })->keyBy('code');

        $allowanceComponent = $components->get('ALLOW');
        if ($allowanceComponent) {
            foreach ($employees as $employee) {
                EmployeeSalaryComponent::create([
                    'employee_id' => $employee->id,
                    'salary_component_id' => $allowanceComponent->id,
                    'amount' => 500000,
                    'is_active' => true,
                    'effective_from' => $employee->join_date,
                ]);
            }
        }

        $today = Carbon::today();
        foreach ($employeeUsers as $employee) {
            for ($day = 1; $day <= 5; $day++) {
                $workDate = $today->copy()->subDays($day);
                $checkIn = $workDate->copy()->setTime(8, rand(0, 20));
                $checkOut = $workDate->copy()->setTime(17, rand(0, 20));
                $lateMinutes = max(0, $workDate->copy()->setTime(8, 0)->diffInMinutes($checkIn, false));

                Attendance::create([
                    'employee_id' => $employee->id,
                    'work_date' => $workDate->toDateString(),
                    'check_in_at' => $checkIn,
                    'check_out_at' => $checkOut,
                    'status' => 'present',
                    'late_minutes' => $lateMinutes,
                ]);
            }
        }

        $periodStart = Carbon::now()->subMonth()->startOfMonth();
        $periodEnd = Carbon::now()->subMonth()->endOfMonth();
        $run = PayrollRun::create([
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'pay_date' => $periodEnd->toDateString(),
            'status' => 'final',
            'created_by' => $hrd->id,
            'notes' => 'Payroll dummy data untuk contoh laporan.',
        ]);

        foreach ($employeeUsers as $employee) {
            $baseSalary = (float) $employee->base_salary;
            $allowance = 500000;
            $bonus = 250000;
            $lateDeduction = 25000;
            $bpjs = round($baseSalary * ($workSetting->bpjs_percent / 100), 2);
            $tax = round($baseSalary * ($workSetting->tax_percent / 100), 2);

            $totalEarnings = $baseSalary + $allowance + $bonus;
            $totalDeductions = $lateDeduction + $bpjs + $tax;
            $netPay = $totalEarnings - $totalDeductions;

            $payroll = Payroll::create([
                'payroll_run_id' => $run->id,
                'employee_id' => $employee->id,
                'base_salary' => $baseSalary,
                'total_earnings' => $totalEarnings,
                'total_deductions' => $totalDeductions,
                'net_pay' => $netPay,
                'generated_at' => now(),
                'status' => 'paid',
            ]);

            $items = [
                ['code' => 'BASIC', 'name' => 'Gaji Pokok',    'type' => 'allowance', 'amount' => $baseSalary],
                ['code' => 'ALLOW', 'name' => 'Tunjangan',     'type' => 'allowance', 'amount' => $allowance],
                ['code' => 'BONUS', 'name' => 'Bonus',         'type' => 'allowance', 'amount' => $bonus],
                ['code' => 'LATE',  'name' => 'Keterlambatan', 'type' => 'deduction', 'amount' => $lateDeduction],
                ['code' => 'BPJS',  'name' => 'BPJS',          'type' => 'deduction', 'amount' => $bpjs],
                ['code' => 'TAX',   'name' => 'Pajak',         'type' => 'deduction', 'amount' => $tax],
            ];

            foreach ($items as $item) {
                $component = $components->get($item['code']);
                PayrollItem::create([
                    'payroll_id' => $payroll->id,
                    'salary_component_id' => $component?->id,
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'amount' => $item['amount'],
                    'meta' => null,
                ]);
            }
        }
    }
}
