<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use WeAreDe\TbcPay\TbcPayProcessor;
use \Validator;
use App\Currency;

class PaymentController extends Controller
{
    //


    public function __construct(){

        $this->middleware('auth',['except'=>['success','fail','test']]);

    }

    public function currencies() {

        if(app()->getLocale()=='en'){
//            return $this->failure('Payment is not working at the moment, Please try again later!');
        }else{
//            return $this->failure('გადახდა დროებით არ მუშაობს, სცადეთ მოგვიანებით');
        }

        $currencies = Currency::query()->where('id',1)->first()->toArray();

        return [
            'success'=>true,
            'result'=>$currencies,
            'error'=>''
        ];


    }

    public function create(Request $request) {
//        return redirect('/');
        $redirect_url = auth()->check() ? 'dashboard' : '/';

        $rules = [
            'amount'=>'required|min:0.01|numeric',
            'currency'=>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return redirect($redirect_url)->withInput([
                'data' => [
                    'alert' => "Invalid currencies #223", // todo trans translate
                    'title' => "Kiwi post Error",
                    'success' => true
                ]
            ]); // todo edit text trans
        } else {

            $currency = $request->input('currency');
            $currencies = [
                'USD'=>840,
                'GEL'=>981
            ];

            $rates = Currency::query()->where('id',1)->first()->toArray();


//            return $this->failure($currency);
//            $rates['GBPGEL'] = $rates['USDGEL']/$rates['USDGBP'];
//            $rates['GBPUSD'] = 1/$rates['USDGBP'];

            if(array_key_exists($currency, $currencies)) {
                $currency_type = $currencies[$currency];

                $amount = (double)$request->get('amount');

                $native_amount = round($amount * $rates['GBP'.$currency],2);


            }else{
                return redirect($redirect_url)->withInput([
                    'data' => [
                        'alert' => "Invalid currencies #225", // todo trans translate
                        'title' => "Kiwi post Error",
                        'success' => true
                    ]
                ]); // todo edit text trans
            }


            $cert_path = storage_path('cert/kiwiposttbc.pem');
            $cert_pass = 'kiwipostuklondon';
            $ip = $request->ip();
            $payment = new TbcPayProcessor($cert_path, $cert_pass, $ip);
            $payment->amount = $native_amount * 100;
            $payment->currency = $currency_type; //826 GBP 981 GEL 840 USD
            $payment->description = trans('defaults.add_money');
            $payment->language = app()->getLocale();

            $start = $payment->sms_start_transaction();

            $transaction_id = $start['TRANSACTION_ID'];

            auth()->user()->payment()->save(new Payment([
                    'transaction_id' => $transaction_id,
                    'amount' => $amount, // GBP
                    'native_currency' => $currency,
                    'native_amount' => $native_amount
                ]
            ));

            return view('tbc', compact('start'));
        }

    }

    public function succeed(Request $request) {

        if($request->input('trans_id') != ''){
            $payment = Payment::query()->with('user')->where('transaction_id',$request->input('trans_id'))->where('status_code',null)->first();
            $redirect_url = auth()->check() ? 'dashboard' : '/';
            $cert_path = storage_path('cert/kiwiposttbc.pem');
            $cert_pass = 'kiwipostuklondon';
            $ip = $request->ip();

            $tbc_payment = new TbcPayProcessor($cert_path, $cert_pass, $ip);
            $tbc_status = $tbc_payment->get_transaction_result($request->input('trans_id'));

            if($tbc_status['RESULT'] == 'OK' && $tbc_status['RESULT_CODE'] == '000') {


                if ($payment) {
                    $amount = $payment->amount;
                    $status = $tbc_status['RESULT_CODE'];
                    $user = $payment->user;
                    $payment->status_code = $status;
                    $balance = round(($user->balance + $amount), 2);
                    $user->update(['balance' => $balance]);
                    $payment->save();

                    return redirect($redirect_url)->withInput([
                        'data' => [
                            'alert' => trans('defaults.payments.success'),
                            'title' => "Kiwi post",
                            'success' => true
                        ]
                    ]); // todo edit text trans


                } else {
                    // todo redirect dashboard with fail message
                    return redirect('/');
                }
            }else{
                if($payment){
                    $status = $tbc_status['RESULT_CODE'];
                    $payment->status_code = $status;
                    $payment->save();

                    return redirect($redirect_url)->withInput([
                        'data' => [
                            'alert' => trans('defaults.payments.failure'),
                            'title' => trans('defaults.payments.failure_title'),
                            'success' => false
                        ]
                    ]); // todo edit text trans
                } return redirect('/');
            }
        } return redirect('/');
    }

    public function fail() {

        $redirect_url = auth()->check() ? 'dashboard' : '/';

        return redirect($redirect_url)->withInput( [
            'data'=>[
                'alert'=>"Payment fail, contact bank administrator", // todo trans translate
                'title'=>"Kiwi post says",
                'success'=>false
            ]
        ]); // todo edit text trans

    }

    public function checkIfSuccess(Request $request) {





        return redirect('/');
        if($request->get('trans_id')){

            $ids = [];
            array_push($ids,$request->input('trans_id'));

            $res = [];
            foreach ($ids as $transaction_id) {

                $cert_path = storage_path('cert/kiwiposttbc.pem');
                $cert_pass = 'kiwipostuklondon';
                $ip = $request->ip();

                $tbc_payment = new TbcPayProcessor($cert_path, $cert_pass, $ip);
                $tbc_status = $tbc_payment->get_transaction_result($transaction_id);

                array_push($res,$tbc_status);
            }
            dd($res);

        }else{

            $payments = Payment::query()->where('status_code','999')->where('id','>','449')->where('id','<','580')->get();
            $res = [];

            foreach ($payments as $payment) {
                $cert_path = storage_path('cert/kiwiposttbc.pem');
                $cert_pass = 'kiwipostuklondon';
                $ip = $request->ip();
                $tbc_payment = new TbcPayProcessor($cert_path, $cert_pass, $ip);
                $tbc_status = $tbc_payment->get_transaction_result($payment->transaction_id);
                if($tbc_status['RESULT']=='OK' && $tbc_status['RESULT_CODE']=='000'){
                    $payment->status_code = '000';
                    $payment->save();
                    array_push($res, $tbc_status);
                }

            }

            dd($res);
        }
        return $this->failure('no more trans id');
    }

    public function test(){
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");




        $arr = ["06346c03-092c-4c43-99d7-4d05f784d20e",
            "83df9d73-8450-4def-a66e-191fb3168e4a",
            "099711b9-0c01-479c-b8c4-f5117799d14d",
            "4021649a-a988-4f4e-ace2-fe60474ffc32"];



        $orders = Order::query()->with('user')->whereIn('unicard_unique_id',$arr)->get();
        $columns = array('user_kw','user_name','last name', 'GBP', 'Payment_value', 'Payment_currency','date','invoices');

//        dd($orders);


        $user_ids = [];



//        $payments = Payment::query()->with('user')->where('status_code','000')->where('created_at','>','2019-01-01 00:04:25')->where('created_at','<','2019-05-01 00:04:25')->get();


//        $columns = array('user_kw','user_name','last name', 'GBP', 'Payment_value', 'Payment_currency','date','invoices');

        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach($orders as $payment) {
//            $invoices = "";
//            if(!in_array($payment->user->id,$user_ids)){
//                $user_ids[] = $payment->user->id;
//                $pm = $payment->user->orders()->select('xero_invoice_number')->where('type',0)->where('created_at','>','2019-01-01 00:04:25')->where('created_at','<','2019-05-01 00:04:25')->get()->pluck('xero_invoice_number')->toArray();
//                $invoices = "[ ".implode(' | ',$pm)." ]";
////                dd($pm);
//            }
            fputcsv($file, array($payment->user->id,$payment->user->name,$payment->user->surname,$payment->from_delivery_cost+$payment->to_delivery_cost+$payment->parcel_cost,$payment->unicard_amount,"unicard",$payment->created_at,$payment->xero_invoice_number));
        }
        exit();



//        foreach($payments as $payment) {
//            $invoices = "";
//            if(!in_array($payment->user->id,$user_ids)){
//                $user_ids[] = $payment->user->id;
//                $pm = $payment->user->orders()->select('xero_invoice_number')->where('type',0)->where('created_at','>','2019-01-01 00:04:25')->where('created_at','<','2019-05-01 00:04:25')->get()->pluck('xero_invoice_number')->toArray();
//                $invoices = "[ ".implode(' | ',$pm)." ]";
////                dd($pm);
//            }
//            fputcsv($file, array($payment->user->id,$payment->user->name,$payment->user->surname,$payment->amount,$payment->native_amount,$payment->native_currency,$payment->created_at,$invoices));
//        }
//        exit();




    }
}
