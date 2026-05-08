<?php

namespace App\Http\Controllers;

use App\Models\SalaryComponent;
use Illuminate\Http\Request;

class SalaryComponentController extends Controller
{
    public function index()
    {
        $components = SalaryComponent::latest()->paginate(15);
        return view('settings.salary-components', compact('components'));
    }

    public function edit(SalaryComponent $salary_component)
    {
        $components = SalaryComponent::latest()->paginate(15);
        $edit_component = $salary_component;
        return view('settings.salary-components', compact('components', 'edit_component'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:salary_components',
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction',
            'is_percentage' => 'boolean',
            'is_fixed' => 'boolean',
            'default_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_percentage'] = $request->input('is_percentage') == '1';
        $validated['is_fixed'] = $request->has('is_fixed');
        $validated['is_active'] = $request->input('is_active', '1') == '1';

        SalaryComponent::create($validated);

        return redirect()->route('salary-components.index')->with('status', 'Komponen Gaji berhasil ditambahkan.');
    }

    public function update(Request $request, SalaryComponent $salary_component)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:salary_components,code,'.$salary_component->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction',
            'is_percentage' => 'boolean',
            'is_fixed' => 'boolean',
            'default_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_percentage'] = $request->input('is_percentage') == '1';
        $validated['is_fixed'] = $request->has('is_fixed');
        $validated['is_active'] = $request->input('is_active', '1') == '1';

        $salary_component->update($validated);

        return redirect()->route('salary-components.index')->with('status', 'Komponen Gaji berhasil diperbarui.');
    }

    public function destroy(SalaryComponent $salary_component)
    {
        $salary_component->delete();
        return redirect()->route('salary-components.index')->with('status', 'Komponen Gaji berhasil dihapus.');
    }
}
