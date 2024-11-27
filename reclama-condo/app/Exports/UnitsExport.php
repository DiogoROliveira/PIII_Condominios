<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UnitsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $units;

    public function __construct($units)
    {
        $this->units = $units;
    }

    public function collection()
    {
        return $this->units->map(function ($unit) {
            return [
                'id' => $unit->id,
                'condominium' => $unit->block->condominium->name ?? 'N/A',
                'block' => $unit->block->block ?? 'N/A',
                'unit_number' => $unit->unit_number,
                'status' => ucfirst($unit->status ?? 'unknown'),
                'base_rent' => number_format($unit->base_rent ?? 0, 2, ',', ''),
                'tenant' => $unit->tenant->name ?? 'N/A',
                'created_at' => $unit->created_at ? $unit->created_at->format('Y-m-d') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Condominium',
            'Block',
            'Unit Number',
            'Status',
            'Base Rent',
            'Tenant',
            'Created At',
        ];
    }

    public function styles($sheet)
    {
        // Estilo para os cabeçalhos
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
                'startColor' => ['argb' => 'FFFF00'], // Amarelo
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Estilo para as linhas de dados
        $sheet->getStyle('A2:H' . (count($this->units) + 1))->applyFromArray([
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

        // Largura das colunas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);

        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'B' => '@',
            'C' => '@',
            'D' => '0',
            'E' => '@',
            'F' => '#,##0.00',
            'G' => '@',
            'H' => 'yyyy-mm-dd',
        ];
    }
}
