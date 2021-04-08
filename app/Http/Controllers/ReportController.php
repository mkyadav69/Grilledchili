<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Order;
use App\Models\Item;
use App\Models\Customer;
use Carbon\Carbon;
use App\Disneyplus;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
class ReportController extends Controller
{   

    public function downloadExcel($type)
    {
        $data = Post::get()->toArray();
        return Excel::create('laravelcode', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
    public function getName($id){
        $name = Customer::where('id', $id)->first();
        if(!empty($name)){
            $name = $name->toArray();
            return $name['firstname'];
        }
    }
    public function getItemName($id){
        $name = Item::where('id', $id)->first();
        if(!empty($name)){
            $name = $name->toArray();
            return $name['name'];
        }
    }

    

    public function downloadReport(Request $request){
        try {
            $data = $request->all();
            $sep_date = explode("|", $data['date_range']);
            $from = $sep_date[0];
            $to = $sep_date[1];
            $date = new \Carbon\Carbon($from);
            $start = $date->format('Y-m-d') . " 00:00:00";
            $date = new \Carbon\Carbon($to);
            $date->addDay('+1');
            $end = $date->format('Y-m-d') . " 00:00:00";
            $orders = Order::with('orderItem')->where('truck_id', $data['truck_id'])->whereBetween('created_at', [$start, $end]);
            $order_data = $orders->get();
            if($data['report_type'] == 'order_overview'){
                $col_name =  [
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

            if($data['report_type'] == 'order_details'){
                $col_name =  [
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

            if($data['report_type'] == 'order_processing_efficiency'){
                $col_name =  [
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
            if(!empty($order_data)){
                $store_data = [];
                $order_data = $order_data->toArray();
                foreach ($order_data as $key => $or_data) {
                    $temp_data = [];
                    if($data['report_type'] == 'order_overview'){
                        $temp_data['order_no'] = $or_data['id'];
                        $temp_data['customer_name'] = !empty($or_data['customer_id']) ? $this->getName($or_data['customer_id']) : '';
                        $temp_data['note'] = $or_data['note'];
                        $temp_data['sub_total'] = $or_data['sub_total'];
                        $temp_data['tip'] = $or_data['tip'];
                        $temp_data['tax'] = $or_data['tax'];
                        $temp_data['total'] = $or_data['total'];
                        $temp_data['transaction_type'] = $or_data['payment_method'];
                        $temp_data['order_status'] = $or_data['order_status'];
                        $store_data['data'][] = $temp_data;
                    }
                    if($data['report_type'] == 'order_details'){
                        foreach($or_data['order_item'] as $item=>$item_detail){
                            $temp_data['order_no'] = $or_data['id'];
                            $temp_data['order_status'] = $or_data['order_status'];
                            $temp_data['order_wanted_time'] = $or_data['order_wanted_time'];
                            $temp_data['item_name'] = !empty($item_detail['item_id']) ? $this->getItemName($item_detail['item_id']) : '';
                            $temp_data['customizations'] = $item_detail['customizations'];
                            $temp_data['quantity'] = $item_detail['quantity'];
                            $temp_data['price'] = $item_detail['price'];
                            $temp_data['special_instructions'] = 'NA';
                            $store_data['data'][] = $temp_data;
                        }
                    }
                    if($data['report_type'] == 'order_processing_efficiency'){
                        $temp_data['order_no'] = $or_data['id'];
                        $temp_data['order_status'] = $or_data['order_status'];
                        $temp_data['order_wanted_time'] = $or_data['order_wanted_time'];
                        $temp_data['order_placed_time'] = $or_data['order_placed_time'];
                        $temp_data['order_accepted_time'] = $or_data['order_accepted_time'];
                        $temp_data['order_acceptance_interval'] = $or_data['order_acceptance_interval'];
                        $temp_data['order_ready_time'] = $or_data['order_ready_time'];
                        $temp_data['order_ready_interval'] = $or_data['order_ready_interval'];
                        $temp_data['order_delivered_time'] = $or_data['order_delivered_time'];
                        $temp_data['order_pickup_interval'] = $or_data['order_pickup_interval'];
                        $temp_data['order_rejected_time'] = $or_data['order_rejected_time'];
                        $temp_data['order_rejected_interval'] = $or_data['order_rejected_interval'];
                        $temp_data['order_cancel_interval'] = 'NA';
                        $store_data['data'][] = $temp_data;
                    }

                }
                $store_data['header_name'] = $col_name;
                return Excel::download(new OrderExport($store_data), 'export.xlsx');
            }else{
                $order_data = [];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
