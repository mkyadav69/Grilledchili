<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Order;

class OrderDetailReportSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
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
        $query = Order::with('orderItem');
        if($this->data['truck_id']){
            $query->where('truck_id', $this->data['truck_id']);
        }
        if($this->data['from_date'] && $this->data['to_date']){
            $query->whereBetween('created_at', [$this->data['from_date'], $this->data['to_date']]);
        }
        $final_records = [];
        $orders = $query->where('order_placed', 1)->orderBy('id', 'asc')->get();
        if(!empty($orders)){
            foreach($orders as $order){
                $item_data = $order->orderItem;
                foreach($item_data as $item_order_data){
                    $temp_data = [];
                    $item_detail = $item_order_data->item->toArray();
                    $temp_data['order_no'] = $order->id;
                    $temp_data['order_status'] = !empty($order->order_status) ?  $order->order_status == 'Rejected' ? 'Rejected By Merchant' : $order->order_status  == 'Cancelled' ? 'Cancelled By Customer' : $order->order_status : '' ;
                    $temp_data['order_wanted_time'] = $order->order_wanted_time;
                    $temp_data['item_name'] =  !empty($item_detail['name']) ? $item_detail['name'] : '';
                    $temp_data['customizations'] = $item_order_data['customizations'];
                    $temp_data['quantity'] = $item_order_data['quantity'];
                    $temp_data['price'] = !empty($item_order_data['price']) ? round($item_order_data['price'] / 100, 2) : '';
                    $temp_data['special_instructions'] = $item_order_data['note'];
                    $final_records[] = $temp_data;
                }
            }
        }
        return collect($final_records);
    }

    public function headings(): array{
        return  [
            'Order Number',
            'Final Order Status',
            'Order Wanted Time',
            'Item Name',
            'Item level customizations',
            'Quantity Ordered',
            'Price',
            'Item Level Special Instructions',
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
        return 'Order Details';
    }

}
