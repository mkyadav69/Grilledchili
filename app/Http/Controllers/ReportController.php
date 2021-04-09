<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Order;
use App\Models\Item;
use App\Models\ItemOrder;
use App\Models\Customer;
use Carbon\Carbon;
use App\Exports\DailyOrderReport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ReportController extends Controller
{   
    public function downloadReport(Request $request){
        try {

            $data = $request->all();
            $query_info = [];
            if(!empty($data['date_range'])){
                $sep_date = explode("|", $data['date_range']);
                $from = $sep_date[0];
                $to = $sep_date[1];
                $date = new \Carbon\Carbon($from);
                $start = $date->format('Y-m-d') . " 00:00:00";
                $date = new \Carbon\Carbon($to);
                $date->addDay('+1');
                $end = $date->format('Y-m-d') . " 00:00:00";
                $query_info['from_date'] = $start;
                $query_info['to_date'] = $end;
            }
            if($data['truck_id']){
                $query_info['truck_id'] = $data['truck_id'];
            }
            return Excel::download(new DailyOrderReport($query_info), 'export.xlsx');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
