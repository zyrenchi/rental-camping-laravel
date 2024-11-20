<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        return view('equipment.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'daily_rate' => 'required|numeric',
            'total_stock' => 'required|integer',
            'category' => 'required'
        ]);

        $validatedData['available_stock'] = $validatedData['total_stock'];

        Equipment::create($validatedData);

        return redirect()->route('equipment.index')
            ->with('success', 'Alat camping berhasil ditambahkan');
    }
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.show', compact('equipment'));
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'daily_rate' => 'required|numeric',
            'total_stock' => 'required|integer',
            'category' => 'required'
        ]);

        $equipment = Equipment::findOrFail($id);

        // Update available stock based on new total stock if needed
        $validatedData['available_stock'] = $validatedData['total_stock'];

        $equipment->update($validatedData);

        return redirect()->route('equipment.index')
            ->with('success', 'Alat camping berhasil diperbarui');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Alat camping berhasil dihapus');
    }

}
