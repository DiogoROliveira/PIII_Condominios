<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\MonthlyPayment;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCondominiums = auth()->user()->condominiums->count();

        // Processar os dados para os gráficos no controlador
        $unitsStatus = Unit::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->map(function ($count, $status) {
                return [__(ucfirst($status)), $count];
            })->prepend([__('Status'), __('Count')])->values();

        $paymentsStatus = MonthlyPayment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->map(function ($count, $status) {
                return [__(ucfirst($status)), $count];
            })->prepend([__('Status'), __('Count')])->values();


        $monthlyRevenue = MonthlyPayment::selectRaw('DATE_FORMAT(due_date, "%Y-%m") as month, SUM(amount) as total')
            ->whereYear('due_date', 2024)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromFormat('Y-m', $item->month)->startOfMonth();
                return [$date, (float)$item->total];
            })
            ->tap(function ($collection) {
                $existingMonths = $collection->pluck(0)->map(fn($date) => $date->format('Y-m'));

                for ($month = 1; $month <= 12; $month++) {
                    $monthKey = sprintf('2024-%02d', $month);
                    if (!$existingMonths->contains($monthKey)) {
                        $collection->push([
                            Carbon::createFromFormat('Y-m', $monthKey)->startOfMonth(),
                            0.0
                        ]);
                    }
                }
                return $collection;
            })
            ->sortBy(0)
            ->prepend(['Month', 'Revenue'])
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCondominiums',
            'unitsStatus',
            'paymentsStatus',
            'monthlyRevenue'
        ));
    }
}
