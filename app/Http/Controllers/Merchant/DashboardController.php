<?php

namespace App\Http\Controllers\Merchant;

use ourcodeworld\NameThatColor\ColorInterpreter as NameThatColor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Order;
use App\Models\Item;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function dashboard(){
        $trucks = Truck::query();
        # Last Month Reports
        $last_month_data = Order::select(array(
            \DB::raw('DATE(`created_at`) as `date`'),
            \DB::raw('COUNT(*) as `count`')
            ))->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get('count', 'date');

        if(!empty($last_month_data)){
            $last_date_labels =  $last_month_data->pluck('date')->toArray();
            $last_date_count =  $last_month_data->pluck('count')->toArray();
            $last_month_total = array_sum($last_date_count);
        }

        # Current Month Data
        $current_month_data = Order::select(array(
            \DB::raw('DATE(`created_at`) as `date`'),
            \DB::raw('COUNT(*) as `count`')
            ))->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)
            ->groupBy('date')
            ->orderBy('date', 'ASC');

        if(!empty($current_month_data)){
            $current_date_labels =  $current_month_data->pluck('date')->toArray();
            $current_date_count =  $current_month_data->pluck('count')->toArray();
            $current_month_total = array_sum($current_date_count);
        }

        $data = [
            'data' =>[
                'data1'=>[$current_date_count],
                'data2'=> [$last_date_count]
            ], 
            'labels'=>[$current_date_labels, $last_date_labels],
            'total_amount'=>$last_month_total+$current_month_total,
        ];
        $ratio = [];
        if($current_month_total > $last_month_total){
            $increases_by = $current_month_total-$last_month_total;
            $percent =  ($increases_by/$current_month_total)*100;
            $ratio['increases_by'] = number_format((float)$percent, 2, '.', '');
            $ratio['month'] =  Carbon::now()->format('F');
        }else if($last_month_total > $current_month_total){
            $decreases_by = $last_month_total-$current_month_total;
            $percent =  ($decreases_by/$last_month_total)*100;
            $ratio['decreases_by'] = number_format((float)$percent, 2, '.', '');
            $ratio['month'] =  'By Last '.Carbon::now()->subMonth()->format('F');
        }
        $report = json_encode($data);

        # Sale Report
        $item_array =[];
        $items = Order::with('orderItem')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('order_delivered', 1)->get();
        if(!empty($items)){
            foreach($items as $item){
                $order_items = $item->orderItem;
                foreach($order_items as $m){
                    $item_name = $m->item;
                    if(!empty($item_name)){
                        $item_array[] = $item_name->name;
                    }
                }
            }
        }
        $item = [];
        $graph = [];
        $item_count = array_count_values($item_array);
        $total_count = array_sum($item_count);
        $color_length = count($item_count);
        $color = [];
        if(!empty($item_count)){
            foreach($item_count as $item_name=>$item_value){
                $get_color = $this->random_color();
                $item[$item_name.'_'.$get_color] = round(($item_value/$total_count) * 100, 2).' %';
                $graph[$item_name] = round(($item_value/$total_count) * 100, 2);
                $color[] = '#'.$get_color;
            }
        }
        $sale['data'] = array_values($item);
        $sale['labels'] = array_keys($item);
        $sale['colors'] = $color;

        $graph_data['data'] = array_values($graph);
        $graph_data['labels'] = array_keys($graph);
        $graph_data['colors'] = $color;
        
        $sale_data_per = json_encode($graph_data);
        if(!empty($trucks)){
            $response = [];
            $ui_date = null;
            # multiple truck
            $trucks  = $trucks->pluck('name', 'id')->toArray();
            #Single truck
            // $trucks = ['1'=>'TEST TRUCK'];

            $check_truck_count  = count($trucks);
            if($check_truck_count == 1){
                $truck_key = array_keys($trucks)[0];
                $yesterday = Carbon::yesterday()->format('Y-m-d');
                $ui_date = Carbon::yesterday()->format('d-m-Y');
                $order_details = Order::where('truck_id', $truck_key)->whereDate('created_at', $yesterday);
                $columns = ['order_placed', 'order_accepted', 'order_ready', 'order_cancelled', 'order_delivered', 'order_rejected'];
                $order_details  = $order_details->get();
                foreach($columns as $column) {
                    $response[$column] = $order_details->where($column, 1)->count();
                }
                $revenue = $order_details->where('order_delivered', 1)->sum('total');
                $total_order = count($order_details);
                $response['total_revenue'] = $revenue;
                $response['total_order'] = $total_order;
            }
        }
        return view('merchant.dashboard', compact('trucks', 'report', 'sale_data_per', 'sale', 'response', 'check_truck_count', 'ratio', 'ui_date'));
    }
    
    public function getData(Request $request){
        $data = $request->all();
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $response = [];

        $orders = Order::query();
        $columns = ['order_placed', 'order_accepted', 'order_ready', 'order_cancelled', 'order_delivered', 'order_rejected'];
        if(!empty($data['date_range'])){
            $sep_date = explode("|", $data['date_range']);
            $from = $sep_date[0];
            $to = $sep_date[1];
            $date = new \Carbon\Carbon($from);
            $start = $date->format('Y-m-d') . " 00:00:00";
            $date = new \Carbon\Carbon($to);
            $date->addDay('+1');
            $end = $date->format('Y-m-d') . " 00:00:00";
            $orders->whereBetween('created_at', [$start, $end]);
        }
        if(!empty($data['truck_id'])){
            $orders->where('truck_id', $data['truck_id']);
        }
        if(!empty($data['singel_truck'])){
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $orders->whereDate('created_at', $yesterday);
        }
        $get_order = $orders->get();
        foreach($columns as $column) {
            $status_wise_data = [];
            $order_data_set = $get_order->where($column, 1)->groupBy(function($d) {
                return Carbon::parse($d->created_at)->format('M');
            });
            $get_temp_data = [];
            $moth_data = [];
            foreach ($order_data_set as $key => $value) {
                $get_temp_data[$key] = count($value);
            }
            foreach($month as $m){
                if(!empty($get_temp_data[$m])){
                    $moth_data[$m] = $get_temp_data[$m];    
                }else{
                    $moth_data[$m] = 0;    
                }
            }
            $status_wise_data['count'] = $get_order->where($column, 1)->count();
            $status_wise_data['monthly_data'] = json_encode($moth_data);
            $response[$column] = $status_wise_data;
        }
        # Calcutae all trucks revenue and revenue by month wise
        $test = [];
        $order_dataset = $get_order->where('order_delivered', 1)->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('M');
        });
        $get_tempdata = [];
        $mdata = [];
        foreach ($order_dataset as $key => $value) {
            $total_by_month = array_sum(array_column($value->toarray(), 'total'));
            $get_tempdata[$key] = $total_by_month;
        }
        foreach($month as $m){
            if(!empty($get_tempdata[$m])){
                $mdata[$m] = $get_tempdata[$m];    
            }else{
                $mdata[$m] = 0;    
            }
        }
        
        $all_temp_data = [];
        $all_month_data = [];
        $all_total_order = $orders->get()->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('M');
        });
        foreach ($all_total_order as $key => $value) {
            $all_temp_data[$key] = count($value);
        }
        foreach($month as $m){
            if(!empty($all_temp_data[$m])){
                $all_month_data[$m] = $all_temp_data[$m];    
            }else{
                $all_month_data[$m] = 0;    
            }
        }
        $total_order = count($get_order);
        $revenue = $orders->where('order_delivered', 1)->sum('total');
        $response['total_revenue'] = $revenue;
        $response['total_order'] = $total_order;
        $response['all_month_data'] =  json_encode($all_month_data);
        $response['month_wise_revenue'] =  json_encode($mdata);
        return response()->json(['data' => $response, 'code'=>200]);
    }
}
