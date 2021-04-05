<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Truck;
use Carbon\Carbon;
use DataTables;
use Config;


class TrucksController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTrucks(){
        return view('merchant.truck.truck');
    }

    public function storeTrucks(Request $request){

        $validator = Validator::make($request->all(), [
            'vendor_id' =>"required",
            "truck_name" => "required",
            "truck_alias" => "required",
            "latitude" => "required",
            "longitude" =>"required",
            "descriptions" => "required",
            "website" => "required",
            "address" => "required",
            'phone'=> "required",
            "operating_time" => "required",
            "weekdays_time" => "required",
            "weekend_time" => "required",
            "ratings" => "required",
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator, 'add_truck')->withInput();
        }
        $check_status = Truck::insertGetId([
            'vendor_id'=>$request->vendor_id,
            'name'=>$request->truck_name,
            'alias'=>$request->truck_alias,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'description'=>$request->description,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'address'=>$request->address,
            'operatingtime'=>$request->operating_time,
            'weekdaytime'=>$request->weekdays_time,
            'weekendtime'=>$request->weekend_time,
            'rating'=>$request->ratings,
            'created_at'=>Carbon::now(),
        ]);

       
        if(!empty($check_status)){
            return back()->with([
                'truck_message' => 'Truck added successfully !',
            ]);
        }
    }

    public function getTrucks(Request $request){
        $customer = Datatables::of(Truck::query());
        // if(Auth::user()->hasPermission('update_customer')){
            $action_btn[] = '<div class="table-data-feature"><button row-id="" class="item edit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="zmdi zmdi-edit text-primary"></i></button></div>';
        // }
        
        // if(Auth::user()->hasPermission('delete_customer')){
            $action_btn[] = '<div class="table-data-feature"><button row-id="" class="item delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="zmdi zmdi-delete text-danger"></i></button></div>';
        // }

        // if(Auth::user()->hasPermission(['update_customer', 'delete_customer'])){
            $customer->addColumn('actions', function ($customer) use($action_btn){
                return '<div class="table-data-feature">'.implode('', $action_btn).'</div>';
               
            })->setRowAttr([
                'data-id' => function($customer) {
                    return $customer->system_id;
                }
            ])->rawColumns(['actions' => 'actions']);
        // }else{
            // $customer->addColumn('actions', function ($customer){
            //     return '<div class="table-data-feature"><button row-id="" class="item" data-toggle="tooltip" data-placement="top" title="View Only"><i class="fa fa-eye text-primary"></i></button></div>';
               
            // })->setRowAttr([
            //     'data-id' => function($customer) {
            //         return $customer->system_id;
            //     }
            // ])->rawColumns(['actions' => 'actions']);
        // }
        $customer->editColumn('created_at', function ($customer) {
            $date = $customer['created_at'];
            if(!empty($date)){
                return date('d-m-Y', strtotime($date));
            }
        })->make(true);

        return $customer->make(true);
    }

    public function updateTrucks(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'vendor_id' =>"required",
            "truck_name" => "required",
            "truck_alias" => "required",
            "latitude" => "required",
            "longitude" =>"required",
            "descriptions" => "required",
            "website" => "required",
            "address" => "required",
            'phone'=> "required",
            "operating_time" => "required",
            "weekdays_time" => "required",
            "weekend_time" => "required",
            "ratings" => "required",
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator, 'update_truck')->withInput();
        }
        $check_status = Truck::where('id', $id)->update([
            'vendor_id'=>$request->vendor_id,
            'name'=>$request->truck_name,
            'alias'=>$request->truck_alias,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'description'=>$request->descriptions,
            'phone'=>$request->phone,
            'website'=>$request->website,
            'address'=>$request->address,
            'operatingtime'=>$request->operating_time,
            'weekdaytime'=>$request->weekdays_time,
            'weekendtime'=>$request->weekend_time,
            'rating'=>$request->ratings,
            'updated_at'=>Carbon::now(),
        ]);
        if(!empty($check_status)){
            return back()->with([
                'truck_message' => 'Truck updated successfully !',
            ]);
        }
    }

    public function deleteTrucks(Request $request, $id){
        $records = Truck::where('id', $id)->delete();
        if($records == '1'){
            $message =  'Truck deleted successfully !';
        }else{
            $message ='Fail to delete truck !';
        }
        return back()->with([
            'truck_message' =>$message
        ]);
    }
}

