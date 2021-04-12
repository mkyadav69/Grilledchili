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
                if(!empty($data['truck_count']) && $data['truck_count'] == 1){
                    $sep_date = explode("|", $data['date_range']);
                    $sep_count = count($sep_date);
                    $yesterday_date = Carbon::yesterday()->format('d-m-Y');
                    if($sep_count > 1){
                        $from = $sep_date[0];
                        $to = $sep_date[1];
                        if($yesterday_date != $from || $yesterday_date != $to){
                            $date = new Carbon($from);
                            $start = $date->format('Y-m-d') . " 00:00:00";
                            $date = new Carbon($to);
                            $date->addDay('+1');                 
                            $end = $date->format('Y-m-d') . " 00:00:00";
                        }
                    }else{
                        $from = $data['date_range'];
                        $to = $data['date_range'];
                        if($yesterday_date == $from || $yesterday_date == $to){
                            $date = new Carbon($from);
                            $start = Carbon::parse($data['date_range'])->format('Y-m-d') . " 00:00:00";
                            $date = new Carbon($to);
                            $date->addDay('+1');
                            $end =  $date->format('Y-m-d') . " 00:00:00";
                        }else{
                            $date = new Carbon($from);
                            $start = Carbon::parse($data['date_range'])->format('Y-m-d') . " 00:00:00";
                            $date = new Carbon($to);
                            $date->addDay('+1');
                            $end =  $date->format('Y-m-d') . " 00:00:00";
                        }
                    }
                }else{
                    $sep_date = explode("|", $data['date_range']);
                    $sep_count = count($sep_date);
                    if($sep_count > 1){
                        $from = $sep_date[0];
                        $to = $sep_date[1];
                        $date = new Carbon($from);
                        $start = $date->format('Y-m-d') . " 00:00:00";
                        $date = new Carbon($to);
                        $date->addDay('+1');
                        $end = $date->format('Y-m-d') . " 00:00:00";                  
                    }else{
                        $from = $data['date_range'];
                        $to = $data['date_range'];
                        $date = new Carbon($from);
                        $start = $date->format('Y-m-d') . " 00:00:00";
                        $date = new Carbon($to);
                        $date->addDay('+1');
                        $end = $date->format('Y-m-d') . " 00:00:00";
                    }
                }
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
