<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $holidays = Holiday::whereYear('date', $year)->orderBy('date')->get();
        $editHoliday = null;

        if ($request->has('edit')) {
            $editHoliday = Holiday::find($request->edit);
        }

        return view('settings.holidays', compact('holidays', 'year', 'editHoliday'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'  => 'required|date|unique:holidays,date',
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:national,office',
            'notes' => 'nullable|string',
        ]);

        Holiday::create($request->only('date', 'name', 'type', 'notes'));

        return redirect()->route('holidays.index')->with('status', 'Hari libur berhasil ditambahkan.');
    }

    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'date'  => 'required|date|unique:holidays,date,' . $holiday->id,
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:national,office',
            'notes' => 'nullable|string',
        ]);

        $holiday->update($request->only('date', 'name', 'type', 'notes'));

        return redirect()->route('holidays.index')->with('status', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('holidays.index')->with('status', 'Hari libur berhasil dihapus.');
    }
}
