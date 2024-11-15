<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\ComplaintCreatedNotification;
use App\Notifications\ComplaintUpdatedNotification;

class ComplaintController extends Controller
{
    public function index_admin()
    {
        // Recupera todas as reclamações, incluindo os dados do usuário e do tipo de reclamação, para exibição detalhada
        $complaints = Complaint::with(['user', 'complaintType'])->get();

        // Retorna a vista específica para o admin, passando as reclamações
        return view('admin.complaints.home', compact('complaints'));
    }

    public function index_user()
    {
        // Recupera as reclamações do usuário logado
        $complaints = Complaint::with('complaintType')
            ->where('user_id', auth()->id()) // Filtra pelas reclamações do usuário logado
            ->get();

        // Retorna a vista específica para o usuário, passando as reclamações
        return view('user.complaints.user_index', compact('complaints'));
    }

    public function create()
    {
        // Recupera todos os tipos de reclamação
        $complaintTypes = ComplaintType::all();

        // Define o caminho da rota de acordo com o tipo de user
        $breadcrumbRoute = auth()->user()->isAdmin() ? 'admin.complaints' : 'complaints.index';

        // Retorna a view para criar uma nova reclamação
        return view('user.complaints.create', compact('complaintTypes', 'breadcrumbRoute'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'attachments.*' => 'file|mimes:jpg,png,pdf,doc,docx,mp4,mov|max:2048',
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
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
        // Recupera a reclamação pelo ID
        $complaint = Complaint::findOrFail($id);

        // Lista de status disponíveis
        $statuses = ['Pending', 'In Progress', 'Solved'];

        // Retorna a view de edição, passando a reclamação e os status
        return view('admin.complaints.edit', compact('complaint', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        // Valida a solicitação
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Solved',
        ]);

        // Atualiza a reclamação
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
