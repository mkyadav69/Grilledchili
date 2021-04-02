<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TruckSetting;
use App\Models\Truck;
use Carbon\Carbon;
use DataTables;
use Config;

class TrucksSettingController extends Controller
{
    public function showTrucksSetting(){
        return view('merchant.truck_setting.truck_setting');
    }

    public function getTrucksSetting(Request $request){
        $customer = Datatables::of(TruckSetting::query());
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
}
