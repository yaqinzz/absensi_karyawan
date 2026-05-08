<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::latest()->paginate(10);
        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:'.Position::class],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Position::create($validated);

        return redirect()->route('positions.index')->with('status', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:'.Position::class.',code,'.$position->id],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $position->update($validated);

        return redirect()->route('positions.index')->with('status', 'Data jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('status', 'Jabatan berhasil dihapus.');
    }
}
