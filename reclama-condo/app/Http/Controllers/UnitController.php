<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Condominium;
use App\Models\Block;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::select('units.*')
            ->join('blocks', 'units.block_id', '=', 'blocks.id')
            ->join('condominiums', 'blocks.condominium_id', '=', 'condominiums.id')
            ->orderBy('condominiums.name', 'asc')
            ->orderBy('blocks.block', 'asc')
            ->orderBy('units.unit_number', 'asc')
            ->get();


        $total = Unit::count();

        return view('admin.units.home', compact('units', 'total'));
    }

    public function create()
    {
        $condominiums = Condominium::all();
        $blocks = Block::all();

        return view('admin.units.create', compact('condominiums', 'blocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'unit_number' => 'required|integer|min:1',
            'status' => 'required|in:vacant,occupied,reserved,in repair'
        ]);

        $block = Block::findOrFail($request->block_id);

        if ($block->units->count() >= $block->number_of_units) {
            return redirect()->back()->withErrors(['error' => 'Maximum number of units reached for this block.']);
        }

        if ($request->unit_number > $block->number_of_units) {
            return redirect()->back()->withErrors(['error' => 'Unit number cannot be greater than the number of units in this block.']);
        }

        if (Unit::where('unit_number', $request->unit_number)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Unit already exists.']);
        }

        Unit::create([
            'block_id' => $request->block_id,
            'unit_number' => $request->unit_number,
            'status' => $request->status
        ]);

        return redirect()->route('admin.units')->with('success', 'Unit created successfully.');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $condominiums = Condominium::all();
        $blocks = Block::where('condominium_id', $unit->block->condominium_id)->get();

        return view('admin.units.edit', compact('unit', 'condominiums', 'blocks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'unit_number' => 'required|integer|min:1',
            'status' => 'required|in:vacant,occupied,reserved,in repair'
        ]);

        $block = Block::findOrFail($request->block_id);

        if ($block->number_of_units < $request->unit_number) {
            return redirect()->back()->withErrors(['error' => 'Unit number cannot be greater than the number of units in this block.']);
        }

        if (Unit::where('unit_number', $request->unit_number)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Unit already exists.']);
        }

        $unit = Unit::findOrFail($id);

        $unit->update([
            'block_id' => $request->block_id,
            'unit_number' => $request->unit_number,
            'status' => $request->status
        ]);

        return redirect()->route('admin.units')->with('success', 'Unit updated successfully.');
    }

    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()->route('admin.units')->with('success', 'Unit deleted successfully.');
    }
}
