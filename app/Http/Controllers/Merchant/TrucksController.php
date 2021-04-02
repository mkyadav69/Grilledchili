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
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function showTrucks(){
        return view('merchant.truck.truck');
    }

    public function storeTrucks(Request $request){

        $validator = Validator::make($request->all(), [
            "customer_name" => "required",
            "customer_last_name" => "required",
            "customer_company_name" => "required",
            "customer_email" => "required",
            "persion1_name" => "required",
            "persion1_email" => "required",
            "persion2_name" => "required",
            "persion2_email" => "required",
            "customer_address" => "required",
            "customer_country" => "required",
            "customer_state" => "required",
            "customer_city" => "required",
            "customer_pincode" => "required",
            "cust_pin_no" => 'required',
            "customer_classification" => "required",
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator, 'cutomer_add')->withInput();
        }
        $check_status = Customer::insertGetId([
            'st_cust_fname'=>$request->customer_name,
            'st_cust_lname'=>$request->customer_last_name,
            'st_com_name'=>$request->customer_company_name,
            'st_regions'=>$request->customer_region,
            'st_com_address'=>$request->customer_address,

            'st_con_person1'=>$request->persion1_name,
            'st_con_person1_email'=>$request->persion1_email,
            'st_con_person1_mobile'=>$request->persion1_mobile,

            'st_con_person2'=>$request->persion2_name,
            'st_con_person2_email'=>$request->persion2_email,
            'st_con_person2_mobile'=>$request->persion2_mobile,

            'st_cust_city'=>$request->customer_city,
            'st_country'=>$request->customer_country,
            'cust_tin_no'=>$request->tin_no,
            'cust_pin_no'=>$request->cust_pin_no,
            'in_pincode'=>$request->customer_pincode,
            'st_cust_state'=>$request->customer_state,
            'st_cust_mobile'=>$request->customer_mobile,
            'st_cust_email'=>$request->customer_email,
            'st_cust_email_cc'=>$request->customer_email,
            'in_branch'=>$request->customer_branch,

            'owner_id'=>Auth::user()->id,
            'user_id'=>Auth::user()->id,
            'dt_created'=>Carbon::now(),
        ]);

       
        if(!empty($check_status)){
            return back()->with([
                'customer_message' => 'Customer created successfully !',
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

    public function updateCustomer(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "update_customer_name" => 'required',
            "update_customer_last_name" => 'required',
            "update_customer_company_name" => 'required',
            "update_customer_email" => 'required',
            "update_customer_region" => 'required',
            "update_customer_mobile" => 'required',
            "update_gst_no" => 'required',
            "update_tin_no" => 'required',

            "update_persion1_name" => 'required',
            "update_persion1_email" => 'required',
            "update_persion1_mobile" => 'required',

            "update_persion2_name" => 'required',
            "update_persion2_email" => 'required',
            "update_persion2_mobile" => 'required',

            "update_customer_address" => 'required',
            "update_customer_city" => 'required',
            "update_customer_state" => 'required',
            "update_customer_pincode" => 'required',
            "update_customer_branch" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'cutomer_update');
        }
        
        $check_status = Customer::where('in_cust_id', $id)->update([
            'st_cust_fname'=>$request->update_customer_name,
            'st_cust_lname'=>$request->update_customer_last_name,
            'st_com_name'=>$request->update_customer_company_name,
            'st_regions'=>$request->update_customer_region,
            'st_com_address'=>$request->update_customer_address,

            'st_con_person1'=>$request->update_persion1_name,
            'st_con_person1_email'=>$request->update_persion1_email,
            'st_con_person1_mobile'=>$request->update_persion1_mobile,

            'st_con_person2'=>$request->update_persion2_name,
            'st_con_person2_email'=>$request->update_persion2_email,
            'st_con_person2_mobile'=>$request->update_persion2_mobile,

            'st_cust_city'=>$request->update_customer_city,
            'cust_tin_no'=>$request->update_tin_no,
            'cust_pin_no'=>$request->update_gst_no,
            'in_pincode'=>$request->update_customer_pincode,
            'st_cust_state'=>$request->update_customer_state,
            'st_cust_mobile'=>$request->update_customer_mobile,
            'st_cust_email'=>$request->update_customer_email,
            'st_cust_email_cc'=>$request->update_customer_email,
            'in_branch'=>$request->update_customer_branch,

            'owner_id'=>Auth::user()->id,
            'user_id'=>Auth::user()->id,
            'dt_modify'=>Carbon::now(),
        ]);
        if(!empty($check_status)){
            return back()->with([
                'customer_message' => 'Customer updated successfully !',
            ]);
        }
    }

    public function deleteCustomer(Request $request, $id){
        $records = Customer::where('in_cust_id', $id)->delete();
        if($records == '1'){
            $message =  'Records deleted successfully !';
        }else{
            $message ='Fail to delete record !';
        }
        return back()->with([
            'customer_message' =>$message
        ]);
    }

    public function showOwner(){
        return view('office.customer.owner');
    }

    public function storeOwner(Request $request){
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required',
            'owner_desciption'=>'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'owner_add')->withInput();
        }
        $check_status = Owner::insertGetId([
            'owner_name'=>$request->owner_name,
            'owner_desc'=>$request->owner_desciption,
            'dt_created'=>Carbon::now(),
        ]);

       
        if(!empty($check_status)){
            return back()->with([
                'message' => 'Owner created successfully !',
            ]);
        }
    }

    public function getOwner(Request $request){
        $owner = Datatables::of(Owner::query());
        if(Auth::user()->hasPermission('update_owner')){
            $action_btn[] = '<div class="table-data-feature"><button row-id="" class="item edit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="zmdi zmdi-edit text-primary"></i></button></div>';
        }
        
        if(Auth::user()->hasPermission('delete_owner')){
            $action_btn[] = '<div class="table-data-feature"><button row-id="" class="item delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="zmdi zmdi-delete text-danger"></i></button></div>';
        }

        if(Auth::user()->hasPermission(['update_owner', 'delete_owner'])){
            $owner->addColumn('actions', function ($owner) use($action_btn){
                return '<div class="table-data-feature">'.implode('', $action_btn).'</div>';
               
            })->setRowAttr([
                'data-id' => function($owner) {
                    return $owner->system_id;
                }
            ])->rawColumns(['actions' => 'actions']);
        }else{
            $owner->addColumn('actions', function ($owner){
                return '<div class="table-data-feature"><button row-id="" class="item" data-toggle="tooltip" data-placement="top" title="View Only"><i class="fa fa-eye text-primary"></i></button></div>';
               
            })->setRowAttr([
                'data-id' => function($owner) {
                    return $owner->system_id;
                }
            ])->rawColumns(['actions' => 'actions']);
        }
        $owner->editColumn('dt_created', function ($owner) {
            $date = $owner['dt_created'];
            if(!empty($date)){
                return date('d-m-Y', strtotime($date));
            }
        })->make(true);

        return $owner->make(true);
    }

    public function updateOwner(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'update_owner_name' => 'required',
            'update_owner_desciption'=>'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator, 'owner_update')->withInput();
        }

        $check_status = Owner::where('id', $id)->update([
            'owner_name'=>$request->update_owner_name,
            'owner_desc'=>$request->update_owner_desciption,
            'dt_modify'=>Carbon::now(),
        ]);
        
        if(!empty($check_status)){
            return back()->with([
                'message' => 'Customer updated successfully !',
            ]);
        }
    }

    public function deleteOwner(Request $request, $id){
        $records = Owner::where('id', $id)->delete();
        if($records == '1'){
            $message =  'Records deleted successfully !';
        }else{
            $message ='Fail to delete record !';
        }
        return back()->with([
            'message' =>$message
        ]);
    }


}

