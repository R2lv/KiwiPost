<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use \App\Classes\Msge;
use \Validator;
use Illuminate\Support\Facades\Hash;

class SmsController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');

    }

    public function verifyMobile(Request $request) {

        $rules = [
            'mobile' => 'required',
            'current_password' =>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;
        } else {
            $user_password = auth()->user()->password;
            if(Hash::check($request->input('current_password'), $user_password)) {

                $data = $this->sendSmsVerification($request);

                if($data['success']) {
                    return $data;
                }else{
                    return $data;
                }

            }else{

                return [
                    'success'=>false,
                    'error'=>[
                        'current_password'=>trans('defaults.wrong_password')
                    ]
                ];
            }

        }

    }

    public function verifyToken(Request $request) {


        $rules = [
            'mobile_token' => 'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;

        }else{

            $token = $request->input('mobile_token');

            if(auth()->user()->mobile_token == $token) {
                auth()->user()->update(['mobile'=>auth()->user()->mobile_2, 'mobile_2'=>null,'mobile_token'=>null]);
                auth()->user()->notifications();
                auth()->user()->notifications()->where('button_action','verify_mobile_number')->where('status','0')->update(['status'=>1]);
                return [
                    'success'=>true,
                    'result'=>'',
                    'error'=>''
                ];
            }

        }

        return [
            'success'=>false,
            'result'=>'',
            'error'=>'token error'
        ];

    }

    public function resendVC() {

        if(!empty(auth()->user()->mobile_2)) {
            $result = self::resendSmsVerification(auth()->user()->mobile_2);
            return $result;
        }
        return $this->failure(['no mobile number was found']); // todo translate

    }

    public static function sendSmsVerification(Request $request) {
        $mobile_to = str_replace(' ','',$request->input('mobile'));
        return self::resendSmsVerification($mobile_to);

    }

    public static function resendSmsVerification($mobile_to){
//        if(auth()->user()->country_id == 1) {


            if(starts_with($mobile_to,'995')){

                if (strlen($mobile_to) == 9) {
                    $mobile_to = '995' . $mobile_to;
                } elseif (strlen($mobile_to) == '13') {
                    $mobile_to = substr($mobile_to, 1);
                }

            }
            if (count(User::query()->where('mobile', $mobile_to)->get()) > 0) {
                return [
                    'success' => false,
                    'error' => [
                        'mobile' => trans('defaults.numberExists')
                    ]
                ];
            }

            $token = self::Numeric(6);
            $msge = new Msge();
            $msge->message = 'Tkveni kodia ' . $token; // todo lang file recovery code is
            $msge->to = $mobile_to;
            $msge->send();

            auth()->user()->update(['mobile_2' => $mobile_to, 'mobile_token' => $token]);
            return [
                'success'=>true,
                'result'=>trans('defaults.sms_success'),
                'error'=>''
            ];
//        } // todo remove only from georgia

        return [
            'success'=>false,
            'result'=>'',
            'error'=>trans('defaults.notAccessable')
        ];
    }

    public static function Numeric($length){

        $chars = "1234567890";
        $clen   = strlen( $chars )-1;
        $id  = '';

        for ($i = 0; $i < $length; $i++) {
            $id .= $chars[mt_rand(0,$clen)];
        }
        return ($id);
    }


}
