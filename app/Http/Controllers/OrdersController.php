<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\Events\XeroCheckEvent;
use App\Jobs\ProccessXeroCheck;
use App\Order;
use App\OrderCategory;
use App\Unicard;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use App\Mail\WarningMails;
use Illuminate\Support\Facades\Mail;


//use App\Http\Controllers\UnicardController;

use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    public function __construct(){

        $this->middleware('auth',['except'=>'checkItUp']);

    }

    public function show(){
        $user = auth()->user();
        $orders = $user->orders()->with(['user','fromCountry','toCountry','trustedUser'])->get();
        return [
            'success'=>true,
            'result'=>$orders,
            'error'=>null,
        ];
    }


    public function store(Request $request) {

        $orders = auth()->user()->orders->where('tracking_number',$request->get('tracking_number'))->first();
        if($orders){
            return $this->failure(['tracking_number'=>[trans('defaults.orders.tracking_exists')]]); // tr
        }


        $rules = [
            'from_country_id' => 'required',
            'to_country_id' => 'required',
            'tracking_number' => 'required',
            'obtain_cost'=>'sometimes|required',
            'obtain_currency'=>'sometimes|required',
            'invoice'=>'file|max:1000|mimes:jpeg,pdf,png'
        ];

        $validator = \Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;
        } else {


            if($request->get('to_country_id') == 1) {
                $invoice_required = $this->checkPriceInGel($request->get('obtain_cost'), $request->get('obtain_currency'));
                if ($invoice_required) {
                    if (!$request->has('invoice')) {
                        return $this->failure(['invoice' => trans('validation.required',['attribute'=>trans('validation.attributes.invoice')])]);
                    }
                }
            }
            $fileName = null;

            if($request->hasFile('invoice')) {
                $file = $request->file("invoice");
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $tmpName = time()."_".$name;
                $fileName = $file->storeAs('invoices', $tmpName, ['disk'=>'local']);
            }

            $all = $request->only(['home_delivery','from_country_id','to_country_id', 'tracking_number', 'obtain_cost','obtain_currency','obtain_invoice','obtain_webstore','comment','trusted_id']);
            $all['user_id'] = auth()->user()->id;
            $all['obtain_invoice'] = $fileName;
            // order_category_ids


            $order = Order::query()->create($all);
            $order_categories = $request->get('order_category_ids');

            if(count($order_categories) > 0) {

                $order->category()->sync($order_categories);
            }
            return $this->success(trans('defaults.orders.success'));
        }
    }

    public function update(Request $request) {

//return ($request->all());
        $order = auth()->User()->orders()->find($request->get("order_id"));

        if($order) {
            if(!$order->operator_id){

                $orders = auth()->user()->orders->where('tracking_number',$request->get('tracking_number'))->where('id','!=',$order->id)->first();
                if($orders){
                    return $this->failure(['tracking_number'=>[trans('defaults.orders.tracking_exists')]]); //
                }


                $rules = [
                    'from_country_id' => 'required',
                    'to_country_id' => 'required',
                    'tracking_number' => 'required',
                    'obtain_cost'=>'required|numeric',
                    'obtain_currency'=>'required',
                    'invoice'=>'file|size:2000|mimes:jpeg,pdf,png'
                ];
            } else {
                $rules = [
                    'obtain_cost'=>'required|numeric',
                    'obtain_currency'=>'required',
                    'invoice'=>'file|size:2000|mimes:jpeg,pdf,png',
                ];
            }

            $validator = \Validator::make($request->input(), $rules);

            if ($validator->fails()) {
                $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
                return $result;
            } else {

                // if from user
                if(!$order->operator_id) {
                    if ($request->get('to_country_id') == 1) {
                        $invoice_required = $this->checkPriceInGel($request->get('obtain_cost'), $request->get('obtain_currency'));
                        if ($invoice_required && $order->obtain_invoice == '') {
                            if (!$request->has('invoice')) {
                                return $this->failure(['invoice' => trans('validation.required', ['attribute' => trans('validation.attributes.invoice')])]);
                            }
                        }
                    }
                } else{
                    // if from operator
                    if ($order->toCountry->code == 'GE') {
                        $invoice_required = $this->checkPriceInGel($request->get('obtain_cost'), $request->get('obtain_currency'));
                        if ($invoice_required) {
                            if (!$request->has('invoice')) {
                                return $this->failure(['invoice' => trans('validation.required', ['attribute' => trans('validation.attributes.invoice')])]);
                            }
                        }
                    }
                }

                $fileName = [];

                if($request->hasFile('invoice')) {
                    $file = $request->file("invoice");
                    $name = $file->getClientOriginalName();
                    $tmpName = time()."_".$name;
                    $fileName = $file->storeAs('invoices', $tmpName, ['disk'=>'local']);
                    $fileName = ['obtain_invoice'=>$fileName];

                    if($order->obtain_invoice != ''){
                        Storage::disk('local')->delete($order->obtain_invoice);
                    }

                }
//dd((int)(bool)$request->get('home_delivery'));
//return $this->success($request->get('home_delivery') == 'false' ? 0 : 1);

                if(!$order->operator_id) {
                    $order->update(array_merge([
                        'from_country_id'=>$request->get('from_country_id'),
                        'to_country_id'=>$request->get('to_country_id'),
                        'obtain_cost'=>$request->get('obtain_cost'),
                        'obtain_currency'=>$request->get('obtain_currency'),
                        'tracking_number'=>$request->get('tracking_number'),
                        'obtain_webstore'=>$request->get('obtain_webstore'),
                        'home_delivery'=>($request->get('home_delivery') == 'false' ? 0 : 1),
                        'comment'=>$request->get('comment')
                    ],$fileName));

                    $order->category()->sync($request->get("order_category_ids"));

                }else{

                    if($order->home_delivery != (int)$request->get('home_delivery') && $order->paid != 1) {
//                        return "you need to update"; update home delivery


                        // todo if is enabled (it means invoice value is without home delivery cost)
                        // todo if is disabled (it means invoice value is with home delivery cost and we need to update)
                    }else{
                        if($order->home_delivery != (int)$request->get('home_delivery')) {
                            return $this->success(trans('defaults.orders.payment.already_paid')); // ტრანსპორტირების ღირებულება უკვე გადახდილია, სამწუხაროდ თქვენ ვერ ჩართავთ/გააუქმებთ მიტანის სერვისს
                        }
                    }

                    $order->update(array_merge([
                        'obtain_cost'=>$request->get('obtain_cost'),
                        'obtain_currency'=>$request->get('obtain_currency'),
                        'comment'=>$request->get('comment'),
                        'obtain_webstore'=>$request->get('obtain_webstore'),
                        'home_delivery'=>(int)$request->get('home_delivery')
                    ],$fileName));

                    $order->category()->sync($request->get("order_category_ids"));
                }

                return $this->success(trans('defaults.orders.success'));
            }
        }else{

            return $this->failure(['access denied']);
        }
    }


    public function showInvoice(Order $order) {


        $user = auth()->user();

        if($user->can('see',$order)) {
//			dd(Storage::path($order->obtain_invoice));
        	if(File::exists(Storage::path($order->obtain_invoice))) {
				return response()->file(Storage::path($order->obtain_invoice));
			} else {
        		return "Invoice does not exist.";
			}
		} else {
            return $this->permissionDenied();
        }
    }

    private function checkPriceInGel($amount,$valute){
        if($valute != 'GEL') {
//            $currencies = new Currency;
            $currencies = Currency::query()->where('id',1)->first()->toArray();
            $rates = $currencies;
//            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
            if($rates[$valute.'GEL'] * $amount >= 300) {
                return true;
            }
            return false;
        } else{
            if($amount >= 300) {
                return true;
            }
            return false;
        }
    }



    public function payOrder(Order $order) {

//        return $this->failure(trans('გადახდა დროებით შეუძლებელია, გთხოვთ მიმართოთ სერვისცენტრს'));

        if($order && auth()->user()->id == $order->user->id) {
            if(auth()->user()->balance >= $order->cost){
                if($order->cost <= 0) {
                    return $this->failure(trans('defaults.orders.payment.prohibited'));
                }
                if($order->paid == 0) {

                    if($order->xero_invoice_number) {
                        $data_for_xero = [
                            'invoice_number' => $order->xero_invoice_number,
                            'amount' => $order->cost,
                        ];

                        $status = XeroController::pay($data_for_xero);
                    }else{
                        // if xero invoice not exists try to catch somewere
                        $status['success']=true;
                    }
                    if($status['success']==true){
                        $post_balance = (double)auth()->user()->balance - (double)$order->cost;
                        $post_balance = round($post_balance,2);
                        auth()->user()->update(['balance'=>$post_balance]);


                        try {
                            $currencies = Currency::query()->where('id',1)->first()->toArray();
                            $rates = $currencies;
//                            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
                            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
                            if ($rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost > 0) {
                                $priceInGel = $rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost;
                                $priceInGel = round($priceInGel, 3);
                            }
                        }catch (Exception $e){
    //                     todo save error to errors report
                        }
                        if($priceInGel > 0) {
                            if (auth()->user()->unicard != '' && !is_null(auth()->user()->unicard)) { // todo remove s from unicard
                                // todo set points with order weight
                                $unicard = auth()->user()->unicard;
                                $connect = UnicardController::setPoints($unicard, $priceInGel); // todo change weight to cost in gel
                                if ($connect['success']) {
                                    $Ucard = new Unicard(); 
                                    $Ucard->transporting_cost = $priceInGel;
                                    $Ucard->user_id = auth()->user()->id;
                                    $Ucard->trans_id_stan = $connect['stan'];
                                    $Ucard->amount = $connect['data']['Bonus'];
                                    $Ucard->status = 1;
                                    $Ucard->message = $connect['data']['ResultMsg'];
                                    $Ucard->save();

                                } else {

                                    $Ucard = new Unicard();
                                    $Ucard->transporting_cost = $priceInGel;
                                    $Ucard->user_id = auth()->user()->id;
                                    $Ucard->trans_id_stan = $connect['stan'];
                                    $Ucard->status = 0;
                                    $Ucard->message = @$connect['data']['ResultMsg'];
                                    $Ucard->save();
                                }
                            }
                        }
                    }

                    $order->paid = 1;
                    $order->save();

                    return $this->success(trans('defaults.orders.payment.success'));
                }else{
                    return $this->failure(trans('defaults.orders.payment.already_paid'));
                }

            }else{
                return $this->failure(trans('defaults.orders.payment.not_enough_money'));
            }
        }else{
            return $this->permissionDenied();
        }


    }


    public function payOrderByUnicard(Order $order) {
//        return $this->failure(trans('გადახდა დროებით შეუძლებელია, გთხოვთ მიმართოთ სერვისცენტრს'));
         if($order && auth()->user()->id == $order->user->id) {
        
            $unicard = auth()->user()->unicard;

            if($unicard != ''){
                $connect = UnicardController::getAccountInfo($unicard);
// return $connect;
                if($connect['success']){

                    $unicardBonus = $connect['data']['bonus'];
                    $unicardGel = $connect['data']['amount'];

                    $currencies = Currency::query()->where('id',1)->first()->toArray();
                    $rates = $currencies;
                    $gelGBP = round($rates['GELGBP'],3);
                    $GBPGEL = round($rates['GBPGEL'],3);
                    $bonusToGbp = round($unicardGel * $gelGBP,3);
                    
                    $reserveToPay =  round($GBPGEL * $order->cost, 3);
                    if($bonusToGbp >= $order->cost ){
                        if( $order->paid == 0) {
                            $pay_step_first = UnicardController::payFromUnicardStepFirst($unicard, $reserveToPay);
                            // return $pay_step_first;
                            if ($pay_step_first['success']) {
                                $order->update(['unicard_amount' => $reserveToPay, 'unicard_unique_id' => $pay_step_first['stan']]);
                                return $this->success(trans('defaults.unicard.sms'));
                            } else {
                                // return $pay_step_first;
                                return $this->failure(trans('defaults.op_failure'));
                            }
                        }
                        return $this->failure('defaults.orders.payment.already_paid');

                    }
                    return $this->failure(trans('defaults.unicard.nemop'));

                }else{
                    return $this->failure(trans('defaults.unicard.pwpcu'));
                }
            
            }else{
                return $this->failure(trans('defaults.unicard.nua'));
            }

        }
    }

    public function payByUnic(Order $order, $sms) {

        if($order && auth()->user()->id == $order->user->id) {
        
            $unicard = auth()->user()->unicard;

            if($unicard != '' && $sms != ''){
         
                if($order->unicard_amount != '' && !is_null($order->unicard_amount) ){
                    if($order->paid == 0) {
                        $pay_step_second = UnicardController::payFromUnicardStepTwo($unicard, $order->unicard_amount, $sms, $order->unicard_unique_id);
                        // return $pay_step_first;
                        if ($pay_step_second['success']) {

                            $data_for_xero = [
                                'invoice_number' => $order->xero_invoice_number,
                                'amount' => $order->cost,
                            ];

                            if ($order->xero_invoice_number != '' && !is_null($order->xero_invoice_number)) {
                                XeroController::pay($data_for_xero);
                            }
                            $order->update(['paid' => 1]);
                            return $this->success(trans('defaults.unicard.paid_success'));
                        } else {
//                        return $pay_step_second;
                            return $this->failure(trans('defaults.op_failure'));
                        }
                    }
                    return $this->failure(trans('defaults.orders.payment.already_paid'));

                }
                return $this->failure(trans("defaults.unicard.nemop"));

            }else{
                return $this->failure(trans('defaults.unicard.pwpcu'));
            }

        }else{
            return $this->failure(trans('defaults.unicard.nua'));
        }

    }


    public function UnicResendSms(Order $order) {

        if($order && auth()->user()->id == $order->user->id) {

            $unicard = auth()->user()->unicard;

            if($unicard != '' ){

                if($order->unicard_amount != '' && !is_null($order->unicard_amount) ){
                    if($order->paid == 0) {

                        $resendSms = UnicardController::resendSmsCode($unicard, $order->unicard_amount, $order->unicard_unique_id);

                        // return $pay_step_first;
//                    return $resendSms;
                        if ($resendSms['success']) {
                            // todo show
                            return $this->success(trans('defaults.unicard.sms'));
                        } else {

                            return $this->failure(trans('defaults.op_failure'));
                        }
                    }
                    return $this->failure(trans('defaults.orders.payment.already_paid'));

                }
                return $this->failure(trans("defaults.unicard.nemop"));

            }else{
                return $this->failure(trans('defaults.unicard.pwpcu'));
            }

        }else{
            return $this->failure(trans('defaults.unicard.nua'));
        }

    }

    private function isMoreThanAllowed(Order $order){

        $isMoreThan = false;
        if($order->obtain_currency != 'GEL') {
            $currencies = Currency::query()->where('id',1)->first()->toArray();
            $rates = $currencies;
//            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
            if($rates[$order->obtain_currency.'GEL'] * $order->obtain_cost >= 300) {
                return true;
            }
            return false;
        } else{
            if($order->obtain_cost >= 300) {
                return true;
            }
            return false;
        }

    }

    public function getExcell() {
        if(auth()->user()->roles < 0 || auth()->user()->id == 1 || auth()->user()->id == 3){
            $currencies = Currency::query()->where('id',1)->first()->toArray();
            $rates = $currencies;
//            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];

            $personal_order = Order::with(['user','fromCountry','toCountry','category','sender'])->where('type','1')->where('status','inTransit')->where('to_country_id',1)->get(); // personal // todo change status warehouse to inTransit

            $online_order = Order::with(['user','fromCountry','toCountry','category','sender'])->where('type','0')->where('status','inTransit')->where('to_country_id',1)->get(); // todo change warehouse to inTransit

            $orders = [
                [
                    'გზ.ნომერი',
                    'პირადი ნომერი',
                    'სახელი',
                    'გვარი',
                    'ტელეფონი',
                    'მისამართი',
                    'ქვეყანის კოდი',
                    'წონა',
                    'გზ. ტიპი',
                    'დაბ.ტიპი',
                    'რეგ.თარიღი',
                    'საწყობში შემოტანის თარიღი',
                    'დოკუმენტის ნომერი',
                    'ტრანსპორტირების ხარჯები 1',
                    'ტრანსპორტირების ხარჯები 1-ის ვალუტა',
                    'ტრანსპორტირების ხარჯები  2',
                    'ტრანსპორტირების ხარჯები 2-ის ვალუტა',
                    'ტრანსპორტირების სხვა ხარჯები',
                    'ტრანსპორტირების სხვა ხარჯების ვალუტა',
                    'მაღაზიის სახელი',
                    'შენიშვნა',
                    'რეისის ნომერი',
                    'დაბრუნებული',
                    'Type'

                ]
            ];

            $orders2 = [
                [
                    'გზ.ნომერი',
                    'საქონლის კოდი',
                    'დასახელება',
                    'რაოდენობა',
                    'ფასი (ვალუტაში)',
                    'ვალუტა',
                    'შეღავათი',
                    'Type'
                ]
            ];
            $orders3 = [
                [
                    'გზავნილის ნომერი',
                    'ქვე გზავნილის ნომერი',
                    'Type'
                ]
            ];

//dd($online_order);
//dd($personal_order[19]);
            foreach($online_order as $order) {
//                return  Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y');

                $isMoreThan = "2";
                if($order->obtain_currency != 'GEL') {
                    if($rates[$order->obtain_currency.'GEL'] * $order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }

                } else{
                    if($order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }
                }
//                dd($order->category);
                $cat_comments = '';
                foreach ($order->category as $category){
                    $cat_comments = $cat_comments.' '.$category->name.' ,';
                }

//dd($cat_comments);
                $new_arr = [
                    $order->tracking_number,
                    $order->user->personal_number,
                    $order->user->name,
                    $order->user->surname,
                    $order->user->mobile,
                    $order->user->address_1." ".$order->user->address_2,
                    '826', // დიდი ბრიტანეთი
                    $order->weight,
                    '0',
                    $isMoreThan,
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y'),
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y'),
                    '',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    $order->obtain_webstore,
                    $cat_comments.' '.$order->comment,
                    '#',
                    '0',
                    'Online'
                ];
                $new_arr_2 = [
                    $order->tracking_number,
                    '',
                    '',
                    '',
                    $order->obtain_cost,
                    $order->obtain_currency,
                    '',
                    'Online'
                ];
                $new_arr_3 = [
                    $order->tracking_number,
                    '',
                    'Online'
                ];
                array_push($orders,$new_arr);
                array_push($orders2,$new_arr_2);
                array_push($orders3,$new_arr_3);
            }
            foreach($personal_order as $order) {

                $isMoreThan = "2";
                if($order->obtain_currency != 'GEL') {
                    if($rates[$order->obtain_currency.'GEL'] * $order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }

                } else{
                    if($order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }
                }

                $cat_comments = '';
                foreach ($order->category as $category){
                    $cat_comments = $cat_comments.' '.$category->name.' ,';
                }

                $new_arr = [
                    $order->tracking_number,
                    $order->user->personal_number,
                    $order->user->name,
                    $order->user->surname,
                    $order->user->mobile,
                    $order->user->address_1." ".$order->user->address_2,
                    '826', // დიდი ბრიტანეთი
                    $order->weight,
                    '0',
                    $isMoreThan,
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y'),
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y'),
                    '',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    $order->obtain_webstore,
                    $cat_comments.' '.$order->comment,
                    '#',
                    '0',
                    'Personal'
                ];
                $new_arr_2 = [
                    $order->tracking_number,
                    '', 
                    '',
                    '',
                    $order->obtain_cost,
                    $order->obtain_currency,
                    '',
                    'Personal'
                ];
                $new_arr_3 = [
                    $order->tracking_number,
                    '',
                    'Personal'
                ];
                array_push($orders,$new_arr);
                array_push($orders2,$new_arr_2);
                array_push($orders3,$new_arr_3);
            }
//phpinfo();
//            return;
//            dd(ini_get('memory_limit'));
//dd($online_order);
            Excel::create('KIWI-POST-MANIFEST', function($excel) use ($orders,$orders2,$orders3) {

                $excel->sheet('Sheet1', function($sheet) use ($orders) {

                    $sheet->with($orders);
                    $sheet->mergeCells('A1:x1');

                });

                $excel->sheet('Sheet2', function($sheet) use ($orders2) {

                    $sheet->with($orders2);
                    $sheet->mergeCells('A1:x1');

                });

                $excel->sheet('Sheet2', function($sheet) use ($orders3) {

                    $sheet->with($orders3);
                    $sheet->mergeCells('A1:x1');

                });
            })->export('xlsx');
//            dd($online_order);
        }
    }

    public function getExcellFromGeo() {

        if(auth()->user()->roles < 0 || auth()->user()->id == 1 || auth()->user()->id == 3){
            $currencies = Currency::query()->where('id',1)->first()->toArray();
            $rates = $currencies;
//            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];

            $personal_order = Order::with(['user','fromCountry','toCountry','category','sender'])->where('type','1')->where('to_country_id',2)->get(); // personal // todo change status warehouse to inTransit

            $online_order = Order::with(['user','fromCountry','toCountry','category','sender'])->where('type','0')->where('to_country_id',2)->get(); // todo change warehouse to inTransit

            $orders = [
                [
                    'გზ.ნომერი',
                    'პირადი ნომერი',
                    'სახელი',
                    'გვარი',
                    'ტელეფონი',
                    'მისამართი',
                    'ქვეყანის კოდი',
                    'წონა',
                    'გზ. ტიპი',
                    'დაბ.ტიპი',
                    'რეგ.თარიღი',
                    'საწყობში შემოტანის თარიღი',
                    'დოკუმენტის ნომერი',
                    'ტრანსპორტირების ხარჯები 1',
                    'ტრანსპორტირების ხარჯები 1-ის ვალუტა',
                    'ტრანსპორტირების ხარჯები  2',
                    'ტრანსპორტირების ხარჯები 2-ის ვალუტა',
                    'ტრანსპორტირების სხვა ხარჯები',
                    'ტრანსპორტირების სხვა ხარჯების ვალუტა',
                    'მაღაზიის სახელი',
                    'შენიშვნა',
                    'რეისის ნომერი',
                    'დაბრუნებული',
                    'Type'

                ]
            ];
            $orders2 = [
                [
                    'გზ.ნომერი',
                    'საქონლის კოდი',
                    'დასახელება',
                    'რაოდენობა',
                    'ფასი (ვალუტაში)',
                    'ვალუტა',
                    'შეღავათი',
                    'Type'
                ]
            ];
            $orders3 = [
                [
                    'გზავნილის ნომერი',
                    'ქვე გზავნილის ნომერი',
                    'Type'
                ]
            ];
//            dd($personal_order[0]);
            foreach($online_order as $order) {
//                return  Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y');

                $isMoreThan = "2";
                if($order->obtain_currency != 'GEL') {
                    if($rates[$order->obtain_currency.'GEL'] * $order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }

                } else{
                    if($order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }
                }
//                dd($order->category);
                $cat_comments = '';
                foreach ($order->category as $category){
                    $cat_comments = $cat_comments.' '.$category->name.' ,';
                }

//dd($cat_comments);
                $new_arr = [
                    $order->tracking_number,
                    $order->user->personal_number,
                    $order->user->name,
                    $order->user->surname,
                    $order->user->mobile,
                    $order->user->address_1." ".$order->user->address_2,
                    '826', // დიდი ბრიტანეთი
                    $order->weight,
                    '0',
                    $isMoreThan,
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y'),
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y'),
                    '',
                    $order->cost,
                    'USD',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    $order->obtain_webstore,
                    $cat_comments.' '.$order->comment,
                    '#',
                    '0',
                    'Online'
                ];
                $new_arr_2 = [
                    $order->tracking_number,
                    '',
                    '',
                    '',
                    $order->obtain_cost,
                    $order->obtain_currency,
                    '',
                    'Online'
                ];
                $new_arr_3 = [
                    $order->tracking_number,
                    '',
                    'Online'
                ];
                array_push($orders,$new_arr);
                array_push($orders2,$new_arr_2);
                array_push($orders3,$new_arr_3);
            }
            foreach($personal_order as $order) {

                $isMoreThan = "2";
                if($order->obtain_currency != 'GEL') {
                    if($rates[$order->obtain_currency.'GEL'] * $order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }

                } else{
                    if($order->obtain_cost >= 300) {
                        $isMoreThan = "1";
                    }else{
                        $isMoreThan = "0";
                    }
                }

                $cat_comments = '';
                foreach ($order->category as $category){
                    $cat_comments = $cat_comments.' '.$category->name.' ,';
                }

                $new_arr = [
                    $order->tracking_number,
                    $order->user->personal_number,
                    $order->user->name,
                    $order->user->surname,
                    $order->user->mobile,
                    $order->user->address_1." ".$order->user->address_2,
                    '826', // დიდი ბრიტანეთი
                    $order->weight,
                    '0',
                    $isMoreThan,
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->user->created_at)->format('d.m.Y'),
                    Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y'),
                    '',
                    $order->cost,
                    'USD',
                    '0',
                    'USD',
                    '0',
                    'USD',
                    $order->obtain_webstore,
                    $cat_comments.' '.$order->comment,
                    '#',
                    '0',
                    'Personal'
                ];
                $new_arr_2 = [
                    $order->tracking_number,
                    '',
                    '',
                    '',
                    $order->obtain_cost,
                    $order->obtain_currency,
                    '',
                    'Personal'
                ];
                $new_arr_3 = [
                    $order->tracking_number,
                    '',
                    'Personal'
                ];
                array_push($orders,$new_arr);
                array_push($orders2,$new_arr_2);
                array_push($orders3,$new_arr_3);
            }

//            dd($orders);
//dd($online_order);


            Excel::create('KIWI-POST-MANIFEST', function($excel) use ($orders,$orders2,$orders3) {

                $excel->sheet('Sheet1', function($sheet) use ($orders) {

                    $sheet->with($orders);
                    $sheet->mergeCells('A1:x1');

                });

                $excel->sheet('Sheet2', function($sheet) use ($orders2) {

                    $sheet->with($orders2);
                    $sheet->mergeCells('A1:x1');

                });

                $excel->sheet('Sheet3', function($sheet) use ($orders3) {

                    $sheet->with($orders3);
                    $sheet->mergeCells('A1:x1');

                });
            })->export('xlsx');
            dd($online_order);
        }

    }

    public function checkItUp(Request $request) {




//        dd('123');
        $resulted_data = [];

        if($request->get('events')){
            $resulted_data = $request->get('events');
        }




        $rawPayload = file_get_contents('php://input');

        $webhookKey = 'mPoa+gN39tPhpt0WElZqckh0mdcxqBbsVsIsVNYtjNMQL6NaMigTYGaVfb8reiyzXyvuDkN2BArbwSd9HVHjbg==';

        $computedSignatureKey = base64_encode(
            hash_hmac('sha256', $rawPayload, $webhookKey, true)
        );
        $xeroSignatureKey = $_SERVER['HTTP_X_XERO_SIGNATURE'];

        if (hash_equals($computedSignatureKey, $xeroSignatureKey)) {

            if(count($resulted_data)) {

//                event(new XeroCheckEvent($resulted_data));

                $this->dispatch(new ProccessXeroCheck($resulted_data));

            }


            return response()->make("",200);
        } else {
            return response()->make("",401);
        }





    }

    public function testit() {

        $arr = [["resourceUrl"=>"https://api.xero.com/api.xro/2.0/Invoices/349c96a2-36a7-4782-a54b-025c15818842",
            "resourceId"=>"349c96a2-36a7-4782-a54b-025c15818842", "eventDateUtc"=>"2018-10-11T07:29:02.111","eventType"=>"UPDATE","eventCategory"=>"INVOICE","tenantId"=>"a77a6315-5bba-48c1-8d7c-4ae449ec31b7","tenantType"=>"ORGANISATION"]];

        $this->dispatch(new ProccessXeroCheck($arr));
        echo "success";

    }




}
