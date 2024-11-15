<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Models\Condominium;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::orderBy('condominium_id', 'asc')
            ->orderBy('block', 'asc')
            ->get();
        $total = Block::count();

        return view('admin.blocks.home', compact('blocks', 'total'));
    }

    public function create()
    {
        $condominiums = Condominium::get();
        return view('admin.blocks.create', compact('condominiums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'condominium_id' => 'required|exists:condominiums,id',
            'block' => 'required|string|max:255',
            'number_of_units' => 'required|integer|min:1',
        ]);


        $condominium = Condominium::findOrFail($request->condominium_id);

        if ($condominium->blocks->count() >= $condominium->number_of_blocks) {
            return redirect()->back()->withErrors(['error' => __('Maximum number of blocks reached for this condominium.')]);
        }


        Block::create([
            'condominium_id' => $request->condominium_id,
            'block' => $request->block,
            'number_of_units' => $request->number_of_units,
        ]);

        return redirect()->route('admin.blocks')->with('success', __('Block created successfully.'));
    }


    public function edit($id)
    {
        $block = Block::find($id);
        $condominiums = Condominium::get();
        return view('admin.blocks.edit', compact('block', 'condominiums'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'condominium_id' => 'required|exists:condominiums,id',
            'block' => 'required|string|max:255',
            'number_of_units' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.blocks.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $block = Block::find($id);
        $block->update($validator->validated());

        session()->flash('success', __('Block updated successfully.'));
        return redirect()->route('admin.blocks');
    }

    public function destroy($id)
    {
        if (Unit::where('block_id', $id)->exists()) {
            return redirect()->route('admin.blocks')->with('error', __('Block cannot be deleted because it has units.'));
        }

        Block::findOrFail($id)->delete();
        return redirect()->route('admin.blocks')->with('success', __('Block deleted successfully.'));
    }

    public function getBlocks($id)
    {
        $blocks = Block::where('condominium_id', $id)->get();
        return response()->json($blocks);
    }
}
