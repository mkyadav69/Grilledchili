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

    public function getName($id){
        $name = Item::where('id', $id)->first();
        if(!empty($name)){
            $name = $name->toArray();
            return $name['name'];
        }
    }
    public function dashboard(){
        $trucks = Truck::query();

        # Monthy Reports
        $last_month_data = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('order_status', 'Accepted')->sum('total');
        $current_month_data = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)->where('order_status', 'Accepted')->sum('total');
        $last_month_name = Carbon::now()->subMonth()->format('F');
        $current_month_name = Carbon::now()->format('F');
        $data = [
            'data' =>[
                'data1'=>[$current_month_data],
                'data2'=> [$last_month_data]
            ], 
            'labels'=>[$last_month_name, $current_month_name],
        ];
        $report = json_encode($data);

        # Sale Report
        $item_array =[];
        $items = Order::with('orderItem')->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();
        if(!empty($items)){
            foreach($items as $item){
                $order_items = $item->orderItem;
                foreach($order_items as $m){
                    $name = $this->getName($m->item_id);
                    if(!empty($name)){
                        $item_array[] = $name;
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
                $item[$item_name.'_'.$get_color] = round(($item_value/$total_count) * 100, 2);
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
            $trucks = $trucks->pluck('name', 'id')->toArray();
        }
        return view('merchant.dashboard', compact('trucks', 'report', 'sale_data_per', 'sale'));
    }

    public function getData(Request $request){
        $data = $request->all();
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
        $get_order = $orders->get();
        foreach($columns as $column) {
            $response[$column] = $get_order->where($column, 1)->count();
        }
        $revenue = $get_order->where('order_delivered', 1)->sum('total');
        $total_order = $response['order_placed'] + $response['order_accepted'] + $response['order_ready'] + $response['order_cancelled'] + $response['order_delivered'] + $response['order_rejected'];
        $response['total_revenue'] = $revenue;
        $response['total_order'] = $total_order;
        return response()->json(['data' => $response, 'code'=>200]);
    }
}
