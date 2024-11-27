<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Models\Unit;
use App\Models\Block;
use App\Models\Condominium;
use App\Exports\RentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RentMapController extends Controller
{
    public function index(Request $request)
    {
        $monPayments = MonthlyPayment::query();

        if ($request->filled('status') && in_array($request->status, ['pending', 'paid', 'overdue'])) {
            $monPayments->where('status', $request->status);
        }

        if ($request->filled('due_date_from')) {
            $monPayments->whereDate('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $monPayments->whereDate('due_date', '<=', $request->due_date_to);
        }

        if ($request->filled('amount_min')) {
            $monPayments->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $monPayments->where('amount', '<=', $request->amount_max);
        }

        $monPayments = $monPayments->with(['unit.block.condominium', 'tenant.user'])->get();

        $units = Unit::with(['block.condominium'])->get();
        $blocks = Block::with(['condominium'])->get();
        $condominiums = Condominium::all();

        $statuses = MonthlyPayment::select('status')
            ->whereIn('status', ['pending', 'paid', 'overdue'])
            ->distinct()
            ->pluck('status');

        $minAmount = MonthlyPayment::min('amount');
        $maxAmount = MonthlyPayment::max('amount');


        // Retorna a view com os dados
        return view('admin.maps.rents.index', compact(
            'monPayments', 'units', 'blocks', 'condominiums', 'statuses', 'minAmount', 'maxAmount'
        ));
    }


    public function exportPdf(Request $request)
    {
        $monPayments = MonthlyPayment::query();

        if ($request->filled('status')) {
            $monPayments->where('status', $request->status);
        }
        if ($request->filled('due_date_from')) {
            $monPayments->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $monPayments->where('due_date', '<=', $request->due_date_to);
        }
        if ($request->filled('amount_min')) {
            $monPayments->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $monPayments->where('amount', '<=', $request->amount_max);
        }

        $monPayments = $monPayments->get();

        $pdf = Pdf::loadView('admin.maps.rents.pdf', compact('monPayments'))
            ->setPaper('A4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->download('monthly_payments.pdf');
    }

    public function exportExcel(Request $request)
    {
        $monPayments = MonthlyPayment::query();

        if ($request->filled('status')) {
            $monPayments->where('status', $request->status);
        }
        if ($request->filled('due_date_from')) {
            $monPayments->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $monPayments->where('due_date', '<=', $request->due_date_to);
        }
        if ($request->filled('amount_min')) {
            $monPayments->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $monPayments->where('amount', '<=', $request->amount_max);
        }

        $monPayments = $monPayments->get();

        return Excel::download(new RentsExport($monPayments), 'monthly_payments.xlsx');
    }
}
