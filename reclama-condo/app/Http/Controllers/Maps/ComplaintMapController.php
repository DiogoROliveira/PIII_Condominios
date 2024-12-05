<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use App\Models\ComplaintType;
use App\Exports\ComplaintsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ComplaintMapController extends Controller
{
    public function index(Request $request)
    {
        // Obtendo os filtros da requisição
        $complaintTypes = ComplaintType::all();
        $users = User::all();

        // Filtrando as complaints com base nos parâmetros da requisição
        $complaints = Complaint::query();

        if ($request->filled('complaint_type')) {
            $complaints->where('complaint_type_id', $request->complaint_type);
        }

        if ($request->filled('status')) {
            $complaints->where('status', $request->status);
        }

        if ($request->filled('attachment')) {
            $attachmentStatus = $request->attachment == '1' ? 'has' : 'doesNotHave';
            
            $complaints->$attachmentStatus('attachments');
        }


        if ($request->filled('user')) {
            $complaints->where('user_id', $request->user);
        }

        $complaints = $complaints->get();

        return view('admin.maps.complaints.index', compact('complaints', 'complaintTypes', 'users'));
    }

    public function exportPdf(Request $request)
    {
        // Captura os filtros via GET
        $complaints = Complaint::query();

        // Aplicando filtros conforme a solicitação
        if ($request->filled('complaint_type')) {
            $complaints->where('complaint_type_id', $request->complaint_type);
        }

        if ($request->filled('status')) {
            $complaints->where('status', $request->status);
        }

        if ($request->filled('attachment')) {
            $attachmentStatus = $request->attachment == '1' ? 'has' : 'doesNotHave';
            
            $complaints->$attachmentStatus('attachments');
        }

        if ($request->filled('user')) {
            $complaints->where('user_id', $request->user);
        }

        // Obter os resultados filtrados
        $complaints = $complaints->get();

        $pdf = PDF::loadView('admin.maps.complaints.pdf', compact('complaints'))
              ->setPaper('A4', 'landscape')  // 'portrait' se preferir orientação vertical
              ->setOption('isHtml5ParserEnabled', true) // Permite usar o HTML5 e CSS
              ->setOption('isPhpEnabled', true); // Permite usar PHP no HTML

        return $pdf->stream('complaints.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Aplicando os mesmos filtros ao buscar os dados para exportação
        $complaints = Complaint::query();

        if ($request->filled('complaint_type')) {
            $complaints->where('complaint_type_id', $request->complaint_type);
        }

        if ($request->filled('status')) {
            $complaints->where('status', $request->status);
        }

        if ($request->filled('attachment')) {
            $attachmentStatus = $request->attachment == '1' ? 'has' : 'doesNotHave';
            
            $complaints->$attachmentStatus('attachments');
        }

        if ($request->filled('user')) {
            $complaints->where('user_id', $request->user);
        }

        // Obter os resultados filtrados
        $complaints = $complaints->get();

        // Gerar o Excel com os dados filtrados
        return Excel::download(new ComplaintsExport($complaints), 'complaints.xlsx');
    }
}
