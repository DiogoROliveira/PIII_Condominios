<?php
namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ComplaintsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $complaints;

    public function __construct($complaints)
    {
        $this->complaints = $complaints;
    }

    public function collection()
    {
        return $this->complaints->map(function ($complaint) {
            return [
                'id' => $complaint->id,
                'user' => $complaint->user->name, // Supondo que você tenha um relacionamento com 'user'
                'complaint_type' => $complaint->complaintType->name, // Aqui é onde você pega o nome
                'title' => $complaint->title,
                'description' => $complaint->description,
                'status' => $complaint->status,
                'attachments' => $complaint->attachments->count() > 0 ? 'Yes' : 'No',
                'response' => $complaint->response,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 
            'User', 
            'Complaint Type', 
            'Title', 
            'Description', 
            'Status', 
            'Attachments', 
            'Response'
        ];
    }

    public function styles($sheet)
    {
        // Estilo para os cabeçalhos (primeira linha)
        $sheet->getStyle('A1:H1')->applyFromArray([
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
        $sheet->getStyle('A2:H' . (count($this->complaints) + 1))->applyFromArray([
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
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        
        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0', // Formatação de número para a coluna ID
            'B' => '@', // Formatação de texto para a coluna User
            'C' => '@', // Formatação de texto para a coluna Complaint Type
            'D' => '@', // Formatação de texto para a coluna Title
            'E' => '@', // Formatação de texto para a coluna Description
            'F' => '@', // Formatação de texto para a coluna Status
            'G' => '@', // Formatação de texto para a coluna Attachments
            'H' => '@', // Formatação de texto para a coluna Response
        ];
    }
}
