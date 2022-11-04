<?php

namespace App\Http\Controllers;

use App\User;
use App\Currency;
use Illuminate\Http\Request;
use App\Uccp;

class UccpController extends Controller
{
    //

    private $user = "UccF1255";
    private $key = "$$8945iieru34serk234ii66jehfg55$$";
    public function index(Request $request) {
        /*
         * validate
         * save to db payment url
         * unic tocken
         * */

        if($request->has('room_number')){
            $roomNumber = $request->get('room_number');

        }else{
            return [
                'success'=>false,
                'result'=>'',
                'code'=>4003
            ];
        }
        $hash = md5($this->user.$this->key.$roomNumber);

        if($request->has('uccp_hash')){
            if(strtolower($request->get('uccp_hash')) == strtolower($hash)){
//                if("--".strpos(strtolower($roomNumber),'kw')){
//                    $roomNumber = (int)str_replace('kw','',strtolower($roomNumber));
//
//                }

                if($roomNumber){
                    $room_number = (int)$roomNumber;
                    $user = User::find($room_number);
                    if($user){
                        $user_name = $user->name;
                        $user_surname = $user->surname;
                        $user_room_number = $user->id;

                        $currencies = Currency::query()->where('id',1)->first()->toArray();
                        $rates = $currencies;
                        $gelgbp = round($rates['GELGBP'],3);

                        return [
                            'success'=>true,
                            'result'=>[
                                'name'=>$user_name,
                                'lastname'=>$user_surname,
                                'room_number'=>$user_room_number,
                                'gel_gbp' => $gelgbp
                            ],
                            'code'=>4005
                        ];
                    }
                    return [
                        'successs'=>false,
                        'result'=>'',
                        'code'=>4004
                    ];
                }
                return [
                    'success'=>false,
                    'result'=>'',
                    'code'=>4003
                ];
            }
            return [
                'success'=>false,
                'result'=>'',
                'code'=>4002
            ];
        }

        return  [
            'success'=>false,
            'result'=>'',
            'code'=>4001
        ];

    }


    public function store(Request $request) {
        /*
         * validate
         * check to db if finished
         * if true reject
         * if false store
         * */
        if($request->has("paymentId")) {
            if($request->has('room_number')){
                if($request->has('amount')){
                    $paymentId = $request->get('paymentId');
                    $roomNumber = $request->get('room_number');
                    $amo = $request->get('amount');
                }else{
                    return [
                        'success'=>false,
                        'result'=>'',
                        'code'=>4006
                    ];
                }
            }else{
                return [
                    'success'=>false,
                    'result'=>'',
                    'code'=>4003
                ];
            }
        }else{
            return [
                'success'=>false,
                'result'=>'',
                'code'=>4010
            ];
        }
        $hash = md5($this->key.$this->user.$roomNumber.$paymentId.$amo);
//        return $this->key;
        if($request->has('uccp_hash')){
            if($request->get('uccp_hash') == $hash){

                if($request->has('room_number')){
                    $room_number = (int)$request->get('room_number');
                    $user = User::find($room_number);
                    if($user){

                        if($request->has('amount')) {
                            $amount = $request->get('amount');
                            if($amount >= 1) {
                                // check if already paid

                                $paid = Uccp::where('unicId',$paymentId)->where('user_id',$room_number)->first();
                                if($paid){
                                    return [
                                        'success'=>false,
                                        'result'=>'',
                                        'code'=>4009
                                    ];
                                }

                                $currencies = Currency::query()->where('id',1)->first()->toArray();
                                $rates = $currencies;
                                $gelgbp = round($rates['GELGBP'],3);

                                $amount_in_gbp = $amount * $gelgbp;

                                if($amount_in_gbp > 0) {

                                    $balance = (double)$user->balance;
                                    $newBalance = round(($balance + (double)$amount_in_gbp), 2);

                                    $user->balance = $newBalance;
                                    $user->save();

                                    $uccp = new Uccp();
                                    $uccp->user_id = $room_number;
                                    $uccp->amount_GBP = $amount_in_gbp;
                                    $uccp->amount_gel = $amount;
                                    $uccp->status = "000";
                                    $uccp->unicId = $paymentId;
                                    $uccp->save();
                                    $trans_id = $uccp->id;

                                    return [
                                        'success'=>true,
                                        'result'=>[
//                                            "amount_in_gbp"=>$amount_in_gbp,
//                                            "amount_in_gel"=>$amount,
//                                            "one_in_gbp"=>$gelgbp
                                            "transaction_id" => $trans_id,
                                            'paymentId'=>$paymentId
                                        ],
                                        'code'=>4005
                                    ];
                                }
                                $uccp = new Uccp();
                                $uccp->user_id = $room_number;
                                $uccp->amount_GBP = $amount_in_gbp;
                                $uccp->amount_gel = $amount;
                                $uccp->status = "4008";
                                $uccp->save();
                                return [
                                    'success'=>true,
                                    'result'=>'',
                                    'code'=>4008
                                ];
                            }

                            return [
                                'success'=>false,
                                'result'=>'',
                                'code'=>4007
                            ];

                        }
                        return [
                            'success'=>false,
                            'result'=>'',
                            'code'=>4006
                        ];
                    }
                    return [
                        'successs'=>false,
                        'result'=>'',
                        'code'=>4004
                    ];
                }
                return [
                    'success'=>false,
                    'result'=>'',
                    'code'=>4003
                ];
            }
            return [
                'success'=>false,
                'result'=>'',
                'code'=>4002
            ];
        }

        return  [
            'success'=>false,
            'result'=>'',
            'code'=>4001
        ];
    }
}
