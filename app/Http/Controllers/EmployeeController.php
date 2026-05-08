<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['division', 'position', 'user'])->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        $positions = Position::all();
        
        return view('employees.create', compact('divisions', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // User Data
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8'],
            
            // Employee Data
            'nik' => ['required', 'string', 'max:30', 'unique:'.Employee::class],
            'name' => ['required', 'string', 'max:255'],
            'division_id' => ['required', 'exists:divisions,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'join_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'base_salary' => ['required', 'numeric', 'min:0'],
            'address' => ['nullable', 'string'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create User
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Assign Karyawan Role
                $user->assignRole('karyawan');

                // 2. Create Employee
                Employee::create([
                    'user_id' => $user->id,
                    'division_id' => $request->division_id,
                    'position_id' => $request->position_id,
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'join_date' => $request->join_date,
                    'status' => $request->status,
                    'base_salary' => $request->base_salary,
                ]);
            });

            return redirect()->route('employees.index')->with('status', 'Karyawan dan akun login berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $divisions = Division::all();
        $positions = Position::all();
        
        return view('employees.edit', compact('employee', 'divisions', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nik'         => ['required', 'string', 'max:30', Rule::unique('employees')->ignore($employee->id)],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($employee->user_id)],
            'division_id' => ['required', 'exists:divisions,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'join_date'   => ['required', 'date'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
            'base_salary' => ['required', 'numeric', 'min:0'],
            'address'     => ['nullable', 'string'],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            DB::transaction(function () use ($request, $employee) {
                // Update Employee data
                $employee->update([
                    'division_id' => $request->division_id,
                    'position_id' => $request->position_id,
                    'nik'         => $request->nik,
                    'name'        => $request->name,
                    'address'     => $request->address,
                    'phone'       => $request->phone,
                    'join_date'   => $request->join_date,
                    'status'      => $request->status,
                    'base_salary' => $request->base_salary,
                ]);

                // Update related User
                $userData = ['name' => $request->name, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $employee->user->update($userData);
            });

            return redirect()->route('employees.index')->with('status', 'Data karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }
}
