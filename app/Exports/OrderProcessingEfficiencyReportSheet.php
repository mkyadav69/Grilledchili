<?php

namespace App\Exports;

use App\ExportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Order;

class OrderProcessingEfficiencyReportSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
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
        if($this->data['truck_id']){
            $query->where('truck_id', $this->data['truck_id']);
        }
        if($this->data['from_date'] && $this->data['to_date']){
            $query->whereBetween('created_at', [$this->data['from_date'], $this->data['to_date']]);
        }
        $query_data = $query->where('order_placed', 1)->orderBy('id', 'asc')->get();
        if(!empty($query_data)){
            $orders = $query_data->toArray();
            $final_records = [];
            foreach($orders as $order){
                $temp_data['order_no'] = $order['id'];
                $temp_data['order_status'] = $order['order_status'];
                $temp_data['order_wanted_time'] = $order['order_wanted_time'];
                $temp_data['order_placed_time'] = $order['order_placed_time'];
                $temp_data['order_accepted_time'] = $order['order_accepted_time'];
                $temp_data['order_acceptance_interval'] = $order['order_acceptance_interval'];
                $temp_data['order_ready_time'] = $order['order_ready_time'];
                $temp_data['order_ready_interval'] = $order['order_ready_interval'];
                $temp_data['order_delivered_time'] = $order['order_delivered_time'];
                $temp_data['order_pickup_interval'] = $order['order_pickup_interval'];
                $temp_data['order_rejected_time'] = $order['order_rejected_time'];
                $temp_data['order_rejected_interval'] = $order['order_rejected_interval'];
                $temp_data['order_cancel_interval'] = 'NA';
                $final_records[] = $temp_data;
            }
            return collect($final_records);
        }
    }

    public function headings(): array{
        return [
            'Order Number',
            'Final Order Status',
            'Order Wanted Time',
            'Order Placed Time',
            'Order Accepted Time',
            'Acceptance Interval in min. (Accepted Time minus Placed Time)',
            'Order Ready Time',
            'Ready Interval in min. (Ready Time minus Wanted Time)',
            'Order Delivered Time',
            'Pickup Interval in min. (Delivered minus Ready)',
            'Order Rejected Time',
            'Order Rejected Interval (Rejected Time - Placed Time)',
            'Order Cancelled Time',
            'Order Cancelled Interval (Cancelled Time - Placed Time)'
        ];
    }

    public function styles(Worksheet $sheet){
        $sheet->getStyle("D")->getNumberFormat()->setFormatCode('0.00'); 
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'Order Processing Efficiency';
    }

}
