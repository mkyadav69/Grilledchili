<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Config;
use AWS;

class AuthController extends Controller
{   
    public function register(){
        return view('auth.users.register');
    }

    public function registerMerchant(Request $request){
        $this->validate($request,[
            'first_name' => 'required|string|max:100',
            'last_name' =>  'required|string|max:100',
            'email' =>  'required|email|max:100',
            'password' => 'required|min:8',
            'mobile' => 'required|digits:10',
        ]);
        $merchant = User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->first_name,
            'password'=> bcrypt($request->password),
            'email'=> $request->email,
            'mobile' => $request->mobile,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);
        if(!empty($merchant)){
            return redirect()->route('login')->with('success', 'Merchant register successfully, Please login !');
        }
    }

    public function viewLogin(){ 
        if(Session::has('mobile')){
            Session::forget('mobile');        
        }
        return view('auth.users.login');
    }
    
    public function merchantLogin(Request $request){
        $this->validate($request,[
            "mobile" => 'required|digits:10',
        ]);
        if(!empty($request->mobile)){
            $check_merchant = User::where('mobile', $request->mobile)->first();
            if(!empty($check_merchant)){ 
                    $min = pow(10, 4);
                    $max = $min * 10 - 1;
                    $gen_otp = mt_rand($min, $max);
                    $ref_number = Str::random(6);
                    $message = "Your One-Time Password (OTP) is ".$gen_otp.". Please do not share this password with anyone - GrilledChili";
                    $sms = AWS::createClient('sns');
                    $sms->publish([
                            'Message' => $message,
                            'PhoneNumber' => '+1'.$request->mobile, 
                            'MessageAttributes' => [
                                'AWS.SNS.SMS.SMSType'  => [
                                    'DataType'    => 'String',
                                    'StringValue' => 'Transactional',
                                ]
                            ],
                        ]);
                    if(!empty($sms)){
                        $check_merchant->otp = $gen_otp;
                        $check_merchant->otp_status = 1;
                        $check_merchant->save();
                        $mobile = $request->mobile;
                        Session::put('mobile', $mobile);
                        Session::put('change', $mobile);
                        return redirect()->route('merchant_otp')->with(['success'=>'OTP has been send on your register mobile number','mobile_number'=>$request->mobile]);
                    }else{
                        return back()->withErrors([
                            'error' => "Somthing went wrong, please try after sometime",
                        ]);
                    }
            }else{
                return back()->withErrors([
                    'error' => "You don't have any account, Please register first",
                ]);
            }
        }
    }

    public function authMerchant(Request $request){
        $this->validate($request,[
            "otp" => 'required',
        ]);
        if(!empty($request->otp)){
            $check_otp = User::where(['otp'=>$request->otp, 'otp_status'=>1])->first();
            if(!empty($check_otp)){
                if (Auth::loginUsingId($check_otp->id)) {
                    $request->session()->regenerate();
                    Session::forget('mobile');
                    return redirect()->route('dashboard')->with('success', 'Login successfully');
                }
            }
            return redirect()->route('merchant_otp')->with('error', 'Please enter the valid SMS OTP');
        }
    }

    public function OtpVerificationPage(Request $request){
        if(!Session::has('mobile')){
            Session::forget('change');
            return redirect()->route('login')->with('error', 'Please login');
        }
        return view('auth.users.otp_page');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout successfully !');
    }
    
    public function deleteUser(Request $request, $id){
        $records = User::where('id', $id)->delete();
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
