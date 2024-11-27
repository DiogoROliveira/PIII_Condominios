<?php

namespace App\Exports;

use App\Models\MonthlyPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class RentsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $monPayments;

    public function __construct($monPayments)
    {
        $this->monPayments = $monPayments;
    }

    public function collection()
    {
        return $this->monPayments->map(function ($monPayments) {
            return [
                'id' => $monPayments->id,
                'unit' => $monPayments->unit->unit_number . ' - ' . $monPayments->unit->block->block . ' - ' . $monPayments->unit->block->condominium->name,
                'tenant' => $monPayments->tenant->user_id . ' - ' . $monPayments->tenant->user->name,
                'due_date' => $monPayments->due_date ? \Carbon\Carbon::parse($monPayments->due_date)->format('d/m/Y') : 'N/A',
                'amount' => number_format($monPayments->amount ?? 0, 2, ',', '.'),
                'status' => strtoupper($monPayments->status ?? 'N/A'),
                'payment_date' => $monPayments->payment_date ? $monPayments->payment_date->format('d/m/Y') : 'N/A',
                'created_at' => $monPayments->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Unit',
            'Tenant',
            'Due Date',
            'Amount (€)',
            'Status',
            'Payment Date',
            'Created At',
        ];
    }

    public function styles($sheet)
    {
        // Style for headers
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'], // Yellow
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Style for data rows
        $sheet->getStyle('A2:H' . (count($this->monPayments) + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(30); // Adjusted width for Unit
        $sheet->getColumnDimension('C')->setWidth(30); // Adjusted width for Tenant
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(25); // Adjusted width for Created At

        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'B' => '@',
            'C' => '@',
            'D' => 'dd/mm/yyyy',
            'E' => '#,##0.00',
            'F' => '@',
            'G' => 'dd/mm/yyyy',
            'H' => 'dd/mm/yyyy hh:mm',
        ];
    }
}
