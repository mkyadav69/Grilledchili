<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Order;

class OrderOverviewReportSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
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
        $query =  Order::with('customer');
        if(isset($this->data['truck_id']) && !empty($this->data['truck_id'])){
            $query->where('truck_id', $this->data['truck_id']);
        }
        if(isset($this->data['from_date']) && !empty($this->data['to_date'])){
            $query->whereBetween('created_at', [$this->data['from_date'], $this->data['to_date']]);
        }
        $query_data = $query->where('order_placed', 1)->orderBy('id', 'asc')->get();
        if(!empty($query_data)){
            $orders = $query_data->toArray();
            $final_records = [];
            foreach($orders as $order){
                $temp_data = [];
                $temp_data['order_no'] = $order['id'];
                $temp_data['customer_name'] = !empty($order['customer']['firstname']) ? $order['customer']['firstname'] : '';
                $temp_data['note'] = $order['note'];
                $temp_data['sub_total'] = !empty($order['sub_total']) ? round($order['sub_total'] / 100, 2) : '';
                $temp_data['tip'] = !empty($order['tip']) ? round($order['tip'] / 100, 2) : '';
                $temp_data['tax'] = !empty($order['tax']) ? round($order['tax'] / 100, 2) : '';
                $temp_data['total'] = !empty($order['total'])? round($order['total'] / 100, 2) : '';
                $temp_data['transaction_type'] = $order['payment_method'];
                $temp_data['order_status'] = !empty($order['order_status']) ?  $order['order_status'] == 'Rejected' ? 'Rejected By Merchant' : $order['order_status']  == 'Cancelled' ? 'Cancelled By Customer' : $order['order_status'] : '' ;
                $final_records[] = $temp_data;
            }
            return collect($final_records);
        }
    }

    public function headings(): array{
        return  [
            'Order Number',
            'Customer Name',
            'Note',
            'Sub Total',
            'Tip',
            'Tax',
            'Total',
            'Transaction Type',
            'Final Order Status'
        ];
    }

    public function styles(Worksheet $sheet){
        $sheet->getStyle("D")->getNumberFormat()->setFormatCode('0.00'); 
        $sheet->getStyle("E")->getNumberFormat()->setFormatCode('0.00'); 
        $sheet->getStyle("F")->getNumberFormat()->setFormatCode('0.00'); 
        $sheet->getStyle("G")->getNumberFormat()->setFormatCode('0.00'); 
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string{
        return 'Order Overview';
    }
}
