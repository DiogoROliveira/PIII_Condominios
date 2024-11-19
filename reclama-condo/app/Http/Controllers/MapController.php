<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use App\Exports\ComplaintsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class MapController extends Controller
{
    /**
     * Exibe a página do mapa de pagamentos.
     */
    public function paymentMaps()
    {
        return view('admin.maps.payment-maps');
    }

    /**
     * Exibe a página do mapa de reclamações.
     */
    public function complaintMaps()
    {
        return view('admin.maps.complaint-maps');
    }

    /**
     * Exporta os pagamentos para Excel.
     */
    public function exportPaymentsToExcel(Request $request)
    {
        // Aqui você pode adicionar filtros baseados nos campos que o usuário preencher.
        return Excel::download(new PaymentsExport($request->all()), 'payments.xlsx');
    }

    /**
     * Exporta os pagamentos para PDF.
     */
    public function exportPaymentsToPDF(Request $request)
    {
        // Aqui você pode adicionar filtros baseados nos campos que o usuário preencher.
        $data = []; // Substitua pelo resultado filtrado da base de dados
        $pdf = PDF::loadView('exports.payments-pdf', ['data' => $data]);

        return $pdf->download('payments.pdf');
    }

    /**
     * Exporta as reclamações para Excel.
     */
    public function exportComplaintsToExcel(Request $request)
    {
        // Aqui você pode adicionar filtros baseados nos campos que o usuário preencher.
        return Excel::download(new ComplaintsExport($request->all()), 'complaints.xlsx');
    }

    /**
     * Exporta as reclamações para PDF.
     */
    public function exportComplaintsToPDF(Request $request)
    {
        // Aqui você pode adicionar filtros baseados nos campos que o usuário preencher.
        $data = []; // Substitua pelo resultado filtrado da base de dados
        $pdf = PDF::loadView('exports.complaints-pdf', ['data' => $data]);

        return $pdf->download('complaints.pdf');
    }
}
