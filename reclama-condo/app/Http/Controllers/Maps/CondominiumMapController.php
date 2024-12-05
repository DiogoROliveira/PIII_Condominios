<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condominium;
use App\Models\Block;
use App\Models\User;
use App\Exports\CondominiumsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CondominiumMapController extends Controller
{
    public function index(Request $request)
    {
        // Obtendo os valores distintos para os dropdowns
        $cities = Condominium::whereNotNull('city')->distinct()->pluck('city');
        $states = Condominium::whereNotNull('state')->distinct()->pluck('state');
        $postal_codes = Condominium::whereNotNull('postal_code')->distinct()->pluck('postal_code');
        $blocks = Condominium::whereNotNull('number_of_blocks')->distinct()->pluck('number_of_blocks');
        

        // Consulta base para os condomínios
        $condominiums = Condominium::query();

        // Filtro por cidade
        if ($request->filled('city')) {
            $condominiums->where('city', 'like', '%' . $request->city . '%');
        }

        // Filtro por estado
        if ($request->filled('state')) {
            $condominiums->where('state', $request->state);
        }

        // Filtro por código postal
        if ($request->filled('postal_code')) {
            $condominiums->where('postal_code', 'like', '%' . $request->postal_code . '%');
        }

        // Filtro por número de blocos
        if ($request->filled('number_of_blocks')) {
            $condominiums->where('number_of_blocks', $request->number_of_blocks);
        }

        // Obter os condomínios filtrados
        $condominiums = $condominiums->get();

        // Retornar para a view com os dados necessários
        return view('admin.maps.condominiums.index', compact('condominiums', 'cities', 'states', 'postal_codes', 'blocks'));
    }

    public function exportPdf(Request $request)
    {
        // Aplicando filtros conforme a solicitação
        $condominiums = Condominium::query();

        if ($request->filled('city')) {
            $condominiums->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('state')) {
            $condominiums->where('state', $request->state);
        }

        if ($request->filled('postal_code')) {
            $condominiums->where('postal_code', 'like', '%' . $request->postal_code . '%');
        }

        // Filtro por número de blocos
        if ($request->filled('number_of_blocks')) {
            $condominiums->where('number_of_blocks', $request->number_of_blocks);
        }

        $condominiums = $condominiums->get();

        $pdf = Pdf::loadView('admin.maps.condominiums.pdf', compact('condominiums'))
            ->setPaper('A4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('condominiums.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Aplicando filtros conforme a solicitação
        $condominiums = Condominium::query();

        if ($request->filled('city')) {
            $condominiums->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('state')) {
            $condominiums->where('state', $request->state);
        }

        if ($request->filled('postal_code')) {
            $condominiums->where('postal_code', 'like', '%' . $request->postal_code . '%');
        }

        // Filtro por número de blocos
        if ($request->filled('number_of_blocks')) {
            $condominiums->where('number_of_blocks', $request->number_of_blocks);
        }

        $condominiums = $condominiums->get();

        return Excel::download(new CondominiumsExport($condominiums), 'condominiums.xlsx');
    }
}
