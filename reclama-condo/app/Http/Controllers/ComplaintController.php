<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Condominium;
use App\Notifications\ComplaintCreatedNotification;
use App\Notifications\ComplaintUpdatedNotification;

class ComplaintController extends Controller
{
    public function index_admin()
    {
        $complaints = Complaint::with(['user', 'unit.block.condominium', 'complaintType', 'attachments'])->get();
        $condominiums = Condominium::all();
        $complaintTypes = ComplaintType::all();

        return view('admin.complaints.home', compact('complaints', 'condominiums', 'complaintTypes'));
    }

    public function index_user()
    {
        $complaints = Complaint::with('complaintType')
            ->where('user_id', auth()->id())
            ->get();

        return view('user.complaints.user_index', compact('complaints'));
    }

    public function create()
    {
        $user = auth()->user();
        $complaintTypes = ComplaintType::all();
        $units = Unit::whereHas('tenant', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        $tenants = Tenant::where('user_id', $user->id)->get();

        return view('user.complaints.create', compact('complaintTypes', 'units', 'tenants'));
    }


    public function admin_create()
    {
        $complaintTypes = ComplaintType::all();
        $units = Unit::with(['block.condominium'])->get();
        return view('admin.complaints.create', compact('complaintTypes', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'attachments.*' => 'file|mimes:jpg,png,pdf,doc,docx,mp4,mov|max:2048',
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'unit_id' => $request->unit_id,
            'complaint_type_id' => $request->complaint_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                $complaint->attachments()->create([
                    'path' => $path,
                ]);
            }
        }

        auth()->user()->notify(new ComplaintCreatedNotification($complaint));

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.complaints')->with('success', __('Complaint created successfully!'));
        } else {
            return redirect()->route('complaints.index')->with('success', __('Complaint created successfully!'));
        }
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        $statuses = ['Pending', 'In Progress', 'Solved'];

        return view('admin.complaints.edit', compact('complaint', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Solved',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'status' => $request->status,
            'response' => $request->response,
        ]);

        $complaint->user->notify(new ComplaintUpdatedNotification($complaint));

        return redirect()->route('admin.complaints')->with('success', __('Complaint status updated successfully!'));
    }

    public function destroy($id)
    {
        // Recupera a reclamação pelo ID
        $complaint = Complaint::findOrFail($id);

        // Exclui a reclamação
        $complaint->delete();

        return redirect()->route('admin.complaints')->with('success', __('Complaint deleted successfully!'));
    }

    public function download($id)
    {

        $complaint = Complaint::with('attachments')->findOrFail($id);

        if ($complaint->attachments->isEmpty()) {
            return redirect()->back()->with('error', __('No attachments found for this complaint.'));
        }

        $zip = new \ZipArchive();
        $zipFileName = 'attachments_complaint_' . $id . '.zip';
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            foreach ($complaint->attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment->path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($attachment->path));
                } else {
                    return redirect()->back()->withErrors(['error' => __('File not found: ') . $attachment->path]);
                }
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend();
    }

    public function show($id)
    {
        $complaint = Complaint::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.complaints.show', compact('complaint'));
    }
}
