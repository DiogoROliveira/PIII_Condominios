<?php

namespace App\Exports;

use App\Models\Condominium;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CondominiumsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $condominiums;

    public function __construct($condominiums)
    {
        $this->condominiums = $condominiums;
    }

    public function collection()
    {
        return $this->condominiums->map(function ($condominium) {
            return [
                'id' => $condominium->id,
                'name' => $condominium->name,
                'address' => $condominium->address ?? 'N/A', // Novo campo
                'city' => $condominium->city ?? 'N/A', // Novo campo
                'state' => $condominium->state ?? 'N/A', // Novo campo
                'postal_code' => $condominium->postal_code ?? 'N/A', // Novo campo
                'phone' => $condominium->phone ?? 'N/A', // Novo campo
                'email' => $condominium->email ?? 'N/A', // Novo campo
                'number_of_blocks' => $condominium->number_of_blocks ?? 'N/A', // Novo campo
                'admin' => $condominium->admin->name ?? 'N/A', // Relacionamento com o administrador
                'created_at' => $condominium->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Address',
            'City',
            'State',
            'Postal Code',
            'Phone',
            'Email',
            'Number of Blocks',
            'Admin',
            'Created At',
        ];
    }

    public function styles($sheet)
    {
        // Estilo para os cabeçalhos (primeira linha)
        $sheet->getStyle('A1:K1')->applyFromArray([ // Atualizado para incluir 11 colunas
            'font' => [
                'bold' => true,
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'] // Amarelo
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Estilo para o restante das linhas
        $sheet->getStyle('A2:K' . (count($this->condominiums) + 1))->applyFromArray([ // Atualizado para incluir 11 colunas
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Definindo a largura das colunas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(40); // Maior largura para o campo Address
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(25); // Maior largura para o campo Email
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(20);

        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0', // Formatação de número para a coluna ID
            'B' => '@', // Formatação de texto para a coluna Name
            'C' => '@', // Formatação de texto para a coluna Address
            'D' => '@', // Formatação de texto para a coluna City
            'E' => '@', // Formatação de texto para a coluna State
            'F' => '@', // Formatação de texto para a coluna Postal Code
            'G' => '0', // Formatação numérica para a coluna Number of Blocks
            'H' => '@', // Formatação de texto para a coluna Phone
            'I' => '@', // Formatação de texto para a coluna Email
            'J' => '@', // Formatação de texto para a coluna Admin
            'K' => 'yyyy-mm-dd', // Formatação de data para a coluna Created At
        ];
    }
}
