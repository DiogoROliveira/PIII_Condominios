<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplaintType;

class ComplaintTypeController extends Controller
{
    public function index()
    {
        $complaint_types = ComplaintType::orderBy('id', 'asc')->get();
        $total = ComplaintType::count();
        return view('admin.complaint_types.home', compact('complaint_types', 'total'));
    }

    public function create()
    {
        return view('admin.complaint_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Cria o tipo de reclamação
        $complaintType = ComplaintType::create([
            'name' => $request->name,
        ]);

        // Verifica se a criação foi bem-sucedida
        if ($complaintType) {
            session()->flash('success', __('Complaint Type created successfully.'));
            return redirect()->route('admin.complaint-types');
        } else {
            session()->flash('error', __('Failed to create complaint type.'));
            return redirect()->route('admin.complaint-types.create')->withInput(); // Retorna os dados antigos
        }
    }

    public function edit($id)
    {
        $complaintType = ComplaintType::findOrFail($id);
        return view('admin.complaint_types.edit', compact('complaintType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $complaintType = ComplaintType::find($id);

        if (!$complaintType) {
            session()->flash('error', __('Complaint Type not found.'));
            return redirect()->route('admin.complaint-types');
        }

        $complaintType->update([
            'name' => $request->name,
        ]);

        session()->flash('success', __('Complaint Type updated successfully.'));
        return redirect()->route('admin.complaint-types');
    }

    public function destroy($id)
    {
        $complaint_types = ComplaintType::findOrFail($id);
        $complaint_types->delete();

        session()->flash('success', __('Complaint Type deleted successfully.'));
        return redirect()->route('admin.complaint-types');
    }
}
