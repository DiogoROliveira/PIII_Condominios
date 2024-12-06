<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use App\Exports\UnitsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UnitMapController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::query();

        if ($request->filled('status')) {
            $units->where('status', $request->status);
        }

        if ($request->filled('rent_min')) {
            $units->where('base_rent', '>=', $request->rent_min);
        }
        if ($request->filled('rent_max')) {
            $units->where('base_rent', '<=', $request->rent_max);
        }

        $statuses = Unit::select('status')->distinct()->pluck('status');
        $minRent = Unit::min('base_rent');
        $maxRent = Unit::max('base_rent');

        $units = $units->get();

        return view('admin.maps.units.index', compact('units', 'statuses', 'minRent', 'maxRent'));
    }

    public function exportPdf(Request $request)
    {
        $units = Unit::query();

        if ($request->filled('status')) {
            $units->where('status', $request->status);
        }

        if ($request->filled('rent_min')) {
            $units->where('base_rent', '>=', $request->rent_min);
        }
        if ($request->filled('rent_max')) {
            $units->where('base_rent', '<=', $request->rent_max);
        }

        $units = $units->get();

        $pdf = Pdf::loadView('admin.maps.units.pdf', compact('units'))
            ->setPaper('A4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('units.pdf');
    }

    public function exportExcel(Request $request)
    {
        $units = Unit::query();

        if ($request->filled('status')) {
            $units->where('status', $request->status);
        }

        if ($request->filled('rent_min')) {
            $units->where('base_rent', '>=', $request->rent_min);
        }
        if ($request->filled('rent_max')) {
            $units->where('base_rent', '<=', $request->rent_max);
        }

        $units = $units->get();

        return Excel::download(new UnitsExport($units), 'units.xlsx');
    }

}
