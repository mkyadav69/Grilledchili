<?php

namespace App\Exports;

use App\ExportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function collection(){ 
        return collect($this->data['data']);
    }

    public function headings(): array{
        return $this->data['header_name'];
    }

    public function styles(Worksheet $sheet){
        $sheet->getStyle("D")->getNumberFormat()->setFormatCode('0.00'); 
        return [
            1    => ['font' => ['bold' => true], 'color'=>['brown']],
        ];
    }
}
