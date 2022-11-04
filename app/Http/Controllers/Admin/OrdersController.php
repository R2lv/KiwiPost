<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Msge;
use App\Country;
use App\Http\Controllers\XeroController;
use App\Mail\OrderReceived;
use App\Mail\OrderStatuses;
use App\Mail\WarningMails;
use App\Order;
use App\Parameter;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Unicard;
use App\Http\Controllers\UnicardController;
use App\Currency;
class OrdersController extends Controller
{


    public function __construct(){
        $this->middleware('auth');
        $this->middleware('roles');
    }

    public function index(Request $request) {
        $defaultPaginate = 55;
        if(Gate::allows('PARCEL_VIEW_ALL')){
            $search = Order::query()->with(['user','fromCountry','toCountry']);

        } elseif (Gate::allows('PARCEL_ADD')){
            $search = Order::query()->with(['user','fromCountry','toCountry'])->where('operator_id',auth()->user()->id);
        } else {
            return $this->permissionDenied();
        }



        if($request->has('fullname') || $request->has('personal_number') ){

            $search = $search->whereHas('user', function(Builder $query) use ($request){

                if($request->has('fullname')){
                    $query->where(DB::raw("CONCAT(`name`, ' ', `surname`)"), "LIKE", "%{$request->get('fullname')}%");
                }

                if($request->has('personal_number')) {
                    $query->where('personal_number',$request->get('personal_number'));
                }

            });
        }

        if($request->has('dateRange')) {

            $date_array = explode(' - ',$request->get('dateRange'));

            if(count($date_array) == 2){
                $date_from = \DateTime::createFromFormat("m/d/Y", $date_array[0]);
                $date_to = \DateTime::createFromFormat("m/d/Y", $date_array[1]);

                $search = $search->where('created_at','>=',$date_from->format("Y-m-d"))->where('created_at','<=',$date_to->format("Y-m-d"));
                $defaultPaginate = 1000;
            }
        }

        if($request->has('status')){
            $status = $request->get('status');

            $search = $search->where('status',$status);
        }

        if($request->has('to_country_id')){

            $country = $request->get('to_country_id');

            $search = $search->with('toCountry')->where('to_country_id',$country);
        }

        if($request->has('user_id')){

            $user_id = $request->get('user_id');

            $search = $search->where('user_id',$user_id);
        }

        if($request->has('isPaid')){

            $isPaidValue = $request->get('isPaid');

            $search = $search->where('paid',$isPaidValue);

        }

        if($request->has('isDeclared')){

            $isDeclaredValue = $request->get('isDeclared');
            $currency = Currency::find(1);
            $gbpgel = $currency->GBPGEL;
            $eurgel = $currency->EURGEL;
            $usdgel = $currency->USDGEL;
            $sr_currency_gbp = 300 / $gbpgel ;
            $sr_currency_eur = 300 / $eurgel ;
            $sr_currency_usd = 300 / $usdgel ;

            if($isDeclaredValue == 1){
                $search = $search->where('status','!=','obtained')
                    ->where('status','!=','waiting')
                    ->where('type',0)
                    ->where(function($qr) use ($sr_currency_gbp, $sr_currency_eur, $sr_currency_usd) {
                       $qr->where(function($query) use ($sr_currency_gbp,$sr_currency_eur,$sr_currency_usd){
                           $query->where(function($q) use ($sr_currency_gbp){
                               $q->where('obtain_cost','>',0)
                                   ->where('obtain_cost','<',$sr_currency_gbp)
                                   ->where('obtain_currency','GBP');
                           })->orWhere(function($q) use ($sr_currency_eur){
                               $q->where('obtain_cost','>',0)
                                   ->where('obtain_cost','<',$sr_currency_eur)
                                   ->where('obtain_currency','EUR');
                           })->orWhere(function($q) use ($sr_currency_usd){
                               $q->where('obtain_cost','>',0)
                                   ->where('obtain_cost','<',$sr_currency_usd)
                                   ->where('obtain_currency','USD');
                           })->orWhere(function($q){
                               $q->where('obtain_cost','>',0)
                                   ->where('obtain_cost','<',300)
                                   ->where('obtain_currency','GEL');
                           });
                       })
                       ->orWhere(function($query) use ($sr_currency_gbp,$sr_currency_eur,$sr_currency_usd){
                           $query->where(function($q) use ($sr_currency_gbp){
                               $q->where('obtain_cost','>',$sr_currency_gbp)
                                   ->where('obtain_invoice','!=','')
                                   ->where('obtain_currency','GBP');
                           })->orWhere(function($q) use ($sr_currency_eur){
                               $q->where('obtain_cost','>',$sr_currency_eur)
                                   ->where('obtain_invoice','!=','')
                                   ->where('obtain_currency','EUR');
                           })->orWhere(function($q) use ($sr_currency_usd){
                               $q->where('obtain_cost','>',$sr_currency_usd)
                                   ->where('obtain_invoice','!=','')
                                   ->where('obtain_currency','USD');
                           })->orWhere(function($q){
                               $q->where('obtain_cost','>',300)
                                   ->where('obtain_invoice','!=','')
                                   ->where('obtain_currency','GEL');
                           });
                       });
                    });
            }

            if($isDeclaredValue == 0){

//                return $this->failure($sr_currency_gbp);
                $search = $search->where('status','!=','obtained')
                    ->where('status','!=','waiting')
                    ->where('type',0)
                    ->where(function($qr) use ($sr_currency_gbp,$sr_currency_eur,$sr_currency_usd){
                        $qr->where(function($query) use ($sr_currency_gbp,$sr_currency_eur,$sr_currency_usd){
                            $query->where(function($q) use ($sr_currency_gbp){
                               $q->where('obtain_cost','>',$sr_currency_gbp)
                                   ->where('obtain_invoice','=','')
                                   ->where('obtain_currency','GBP');
                            })
                            ->orWhere(function($q) use ($sr_currency_eur){
                                $q->where('obtain_cost','>',$sr_currency_eur)
                                    ->where('obtain_invoice','=','')
                                    ->where('obtain_currency','EUR');
                            })
                            ->orWhere(function($q) use ($sr_currency_usd){
                                $q->where('obtain_cost','>',$sr_currency_usd)
                                    ->where('obtain_invoice','=','')
                                    ->where('obtain_currency','USD');
                            })
                            ->orWhere(function($q) use ($sr_currency_gbp){
                                $q->where('obtain_cost','>',300)
                                    ->where('obtain_invoice','=','')
                                    ->where('obtain_currency','GEL');
                            });
                        })
                        ->orWhere('obtain_cost',null);
                    });

            }


        }

        if($request->has('tracking_number')){

            $tracking_number = $request->get('tracking_number');

            $search = $search->where('tracking_number',$tracking_number);
        }

        if($request->has('home_delivery')) {
            $search = $search->where('home_delivery', $request->get('home_delivery'));
        }

        return $this->success($search->orderBy('id','desc')->paginate($defaultPaginate));

    }


    public function stats(){

        $paid = Order::query()->where('paid',1);
        $ows = Order::query()->where('paid',0);

        $dt_pers = DB::select("SELECT SUM(parcel_cost) AS cost, SUM(from_delivery_cost) AS from_cost, SUM(to_delivery_cost) AS to_cost, CONCAT(YEAR(created_at), ' W', WEEK(`created_at`)) AS week_number FROM orders where type=1  GROUP BY week_number");
        $dt_on = DB::select("SELECT SUM(parcel_cost) AS cost, SUM(from_delivery_cost) AS from_cost, SUM(to_delivery_cost) AS to_cost, CONCAT(YEAR(created_at), ' W', WEEK(`created_at`)) AS week_number FROM orders where type=0  GROUP BY week_number");

        $data_pers = [];
        $data_on = [];
        $data = [];

        foreach ($dt_on as $order) {
            $nd = round($order->cost+$order->from_cost+$order->to_cost,2);

            $data[$order->week_number] = ['online'=>$nd,'personal'=>0,'year_week'=>$order->week_number];
        }
//        dd($data);
//        dd(array_key_exists('2017 W52',$data));
        foreach ($dt_pers as $order) {
            $nd = round($order->cost+$order->from_cost+$order->to_cost,2);

            if(array_key_exists($order->week_number,$data)) {
                $data[$order->week_number]['personal']=$nd;
            }else{
                $data[$order->week_number] = ['personal'=>$nd,'year_week'=>$order->week_number];
            }

        }
//        dd($data);
        $total_ows = round($ows->sum('parcel_cost') + $ows->sum('from_delivery_cost') + $ows->sum('to_delivery_cost'),2);
        $total_invome = round($paid->sum('parcel_cost') + $paid->sum('from_delivery_cost') + $paid->sum('to_delivery_cost'),2);
        $all_parcels = round($paid->count() + $ows->count(),2);

//dd(array_values($data));
        return $this->success([
            'total_ows'=>$total_ows,
            'total_income'=>$total_invome,
            'all_parcels'=>$all_parcels,
            'dt'=>array_values($data)
        ]);

    }

    public function show($id) {
        if(Gate::allows('PARCEL_ADD')){
            return $this->success(Order::query()->with('user.country','sender.country','category')->find($id));
        }
        return $this->permissionDenied();

    }


//    public function search(Request $request) {
//
//
//        $search = Order::query()->with(['user']);
//        $searchable = false;
//        if($request->has('fullname') || $request->has('personal_number') ){
//
//            $search = $search->whereHas('user', function(Builder $query) use ($request){
//
//                if($request->has('fullname')){
//                    $query->where(DB::raw("CONCAT(`name`, ' ', `surname`)"), "LIKE", "%{$request->get('fullname')}%");
//                }
//
//                if($request->has('personal_number')) {
//                    $query->where('personal_number',$request->get('personal_number'));
//                }
//
//            });
//        }
//
//        if($request->has('dateRange')) {
//
//            $date_array = explode(' - ',$request->get('dateRange'));
//
//            if(count($date_array) == 2){
//                $date_from = \DateTime::createFromFormat("m/d/Y", $date_array[0]);
//                $date_to = \DateTime::createFromFormat("m/d/Y", $date_array[1]);
//
//                $search = $search->where('created_at','>=',$date_from->format("Y-m-d"))->where('created_at','<=',$date_to->format("Y-m-d"));
//
//            }
//        }
//
//        if($request->has('status')){
//            $status = $request->get('status');
//
//            $search = $search->where('status',$status);
//        }
//
//        if($request->has('to_country_id')){
//
//            $country = $request->get('to_country_id');
//
//            $search = $search->with('toCountry')->where('to_country_id',$country);
//        }
//
//        if($request->has('user_id')){
//
//            $user_id = $request->get('user_id');
//
//            $search = $search->where('user_id',$user_id);
//        }
//
//        if($request->has('tracking_number')){
//
//            $tracking_number = $request->get('tracking_number');
//
//            $search = $search->where('tracking_number',$tracking_number);
//        }
//
//        if($request->has('home_delivery')) {
//            $search = $search->where('home_delivery', $request->get('home_delivery'));
//        }
//
//
//        // if($searchable){
//            return $this->success($search->paginate(35));
//        // }else{
//            // return $this->failure(['text'=>'at least one parameter is required']); // todo translate
//        // }
//
//    }


    public function store(Request $request) {

        if(Gate::allows('PARCEL_ADD')){

            $parameter = Parameter::query(); // parameter for queries

            $parcel_type = $request->get('parcel_type');

            $_validator = \Validator::make($request->only('parcel_type'), ['parcel_type'=>'required|in:personal,online']);

            if($_validator->fails()) {
                return $this->failure($_validator);
            }

            $params = $parameter->select('price_list_personal','price_list_online')->where('id',1)->get()[0];
            $personalObject = json_decode($params->price_list_personal,true);
            $onlineObject = json_decode($params->price_list_online, true);

            $_parcelType = $this->parcelType($parcel_type, $onlineObject, $personalObject);


            $rules = $_parcelType['rules'];
            $validator = \Validator::make($request->input(), $rules);
            if ($validator->fails()) {
                return $this->failure($validator);
            }

            $values = array_keys($rules);
            $all = $request->only($values);
            $active_parcel_type = $_parcelType['active_parcel_type'];
            unset($all['room_number']);

            $sender_id = $request->input('sender_id');
            $room_number = $request->input('room_number');

            // calculate price
            $weight = $request->input('weight');

            $from_country = Country::query()->find($request->input('from_country_id'));
            $to_country = Country::query()->find($request->input('to_country_id'));

            $parcel_cost = $this->calculate($weight,$from_country->code,$to_country->code, $active_parcel_type, $parcel_type);

            if($parcel_cost['success']){
                $all['parcel_cost'] = round($parcel_cost['result']['parcel_cost'],2);

                if($request->get('home_delivery')){
                    $all['to_delivery_cost'] = round($parcel_cost['result']['to_delivery_cost'],2);
                    $all['home_delivery'] = 1;
                }

                if($request->get('from_home_delivery')){
                    $all['from_delivery_cost'] = round($parcel_cost['result']['from_delivery_cost'],2);
                }
            }else{
                return $this->failure($parcel_cost['error']);
            }

            $all['sender_id'] = $sender_id;

            if($parcel_type != 'online') {
                if (!$this->userExists($sender_id)) {
                    $response = $this->createSender($request);
                    if ($response['success']) {
                        $all['sender_id'] = $response['result']['user_id'];
                    } else {
                        return $this->failure($response['error']);
                    }
                }
                if(!$this->userExists($room_number)) {

                    $response = $this->createReceiver($request);
                    if ($response['success']) {
                        $room_number = $response['result']['user_id'];
                    } else {
                        return $this->failure($response['error']);
                    }

                }
                $all['type']='1';
            }

            // online
            if(!$this->userExists($room_number)) {

                return $this->failure(['user not exists']);

            }

            $all['user_id'] = $room_number;
            $all['operator_id'] = auth()->user()->id;
            $all['weight'] = $weight;
            $all['status'] = 'warehouse';


            $predeclared_order = false;
            if($request->has("tracking_number")) {

                $alreadyDeclared = Order::query()->where('tracking_number', $all['tracking_number'])
                    ->where('user_id', $room_number)
                    ->where('operator_id', '!=',null)
                    ->where('type', 0)
                    ->first();

                if($alreadyDeclared) {
                    return $this->failure(['ამანათი უკვე დამატებულია']);
                }

                $predeclared_order = Order::query()->where('tracking_number', $all['tracking_number'])
                    ->where('user_id', $room_number)
                    ->where('operator_id', null)
                    ->where('type', 0)
                    ->first();
//return $this->failure([count($predeclared_order)]);
                if($predeclared_order) {
                    $already_added = Order::query()->where('tracking_number', $all['tracking_number'])
                        ->where('operator_id', '!=', null)
                        ->where('user_id', $room_number)
                        ->first();

                    if ($already_added) {
                        return $this->failure(['უკვე დამატებულია']);
                    }
                }
            }
            if($request->has("tracking_number") && $predeclared_order) {
                if($parcel_type == 'online'){
                    if($predeclared_order->status == 'warehouse'){
                        return $this->failure(['text'=>trans('defaults.orders.failure')]);
                    }
                    $user_data = $predeclared_order->user;

                    if($predeclared_order->home_delivery){
//                        dd($parcel_cost);
                        $all['to_delivery_cost'] = round($parcel_cost['result']['to_delivery_cost'],2);
                    }

                }else{
                    $all['xero_invoice_for'] == 'sender' ? $user_data = $predeclared_order->sender : $user_data = $predeclared_order->user;
                }
                $predeclared_order->update($all);


                $return_id = $predeclared_order->id;
                $xero_result = $this->createXeroInvoice($predeclared_order,$user_data);
                if($xero_result['success']){
                    $predeclared_order->xero_invoice_number = $xero_result['invoice_number'];
                    $predeclared_order->xero_payment_url = $xero_result['payment_url'];
                    $predeclared_order->xero_guid = $xero_result['xero_guid'];
                    $predeclared_order->save();

                }else{
                    // todo note that invoice has not been created
                }
//                dd($xero_result);
                $this->mailToUser($predeclared_order);
                $this->msge($predeclared_order);

                return $this->success(['text'=>trans('defaults.orders.success'),'id'=>$return_id]); //


            } else {

                // create order start

                $new_order = Order::query()->create($all);
                if($parcel_type != 'online'){
                    $new_order->category()->sync($all['order_category_ids']);
                }

                if($new_order->tracking_number == null) {
                    $id = (integer)'50605439800010000' + (integer)$new_order->id; // unic id
                    $tracking_number = str_pad($id, 18, '0', STR_PAD_LEFT);
                    $new_order->tracking_number = $tracking_number;
                    $new_order->save();
                }

                if($parcel_type == 'online'){
                    $user_data = $new_order->user;
                }else{
                    $all['xero_invoice_for'] == 'sender' ? $user_data = $new_order->sender : $user_data = $new_order->user;
                }

                $return_id = $new_order->id;
                $xero_result = $this->createXeroInvoice($new_order,$user_data);
                if($xero_result['success']){
//                    return json_encode($xero_result['xero_guid']);
                    $new_order->xero_invoice_number = $xero_result['invoice_number'];
                    $new_order->xero_payment_url = $xero_result['payment_url'];
                    $new_order->xero_guid = $xero_result['xero_guid'];
                    $new_order->save();
                }else{
                    // todo invoice not created
                }
//                return json_encode($xero_result);
                if($parcel_type == 'online') {
                    $this->mailToUser($new_order);
                    $this->msge($new_order);
                }
                // end <== create

                return $this->success(['text'=>trans('defaults.orders.success'),'id'=>$return_id]);

            }

        }

        return $this->permissionDenied();

    }


    public function changeStatus(Request $request) {

        if(Gate::allows('PARCEL_ADD')){

            $ids = $request->get('ids');

            $status = $request->get('status');
            if($status == 'warehouse'){
                return $this->failure(['status can not be changed error code 9883']);
            }

            if(count($ids) > 0 && $status != '') {
                $orders = Order::query()->findMany($ids);

                foreach($orders as $order) {

                    $arr = [];

                    $sms = false;
                    if($status=='inTransit') {
                        $arr = ['tracking'=>$order->tracking_number,'country'=>$order->fromCountry->name,'estimated'=>Carbon::now()->addDays(2)->format('d/m/Y')];
                    }
                    if($status == 'arrived') {
                        $arr = ['tracking'=>$order->tracking_number,'country'=>$order->toCountry->name,'estimated'=>Carbon::now()->addDays(1)->format('d/m/Y')];
                    }
                    if($status == 'terminal'){
                        $arr = ['tracking'=>$order->tracking_number,'country'=>$order->toCountry->name,'estimated'=>Carbon::now()->addDays(1)->format('d/m/Y')];
                    }
                    if($status == 'obtained') {
                        $arr = ['tracking'=>$order->tracking_number,'country'=>''];
                    }
                    if($status == 'stopped') {
                        $arr = ['tracking'=>$order->tracking_number,'country'=>$order->toCountry->name];
                    }
                    if($status == 'arrived') {
                        $arr = ['tracking'=>$order->tracking_number,'country'=>$order->toCountry->name];
                        $sms = 'Tkveni amanati gzavnilis kodiT '.$order->tracking_number.' Chamosulia.  Tkven shegidzliat misi gatana.'; // todo trans message
                    }

                    $order->update(['status' => $status]);
                    $message = trans("mail.order.{$status}", $arr);
                    // return new OrderStatuses($order, $message);

                     $this->mailStatusUpdate($order,$message,$sms);
                }

                return $this->success('operation success');
            }
        }
        return $this->permissionDenied();

        //todo send email that status is changed
        // todo make log when changed

    }

    public function getStatuses() {
        return $this->success(config('defaults.parcels.statuses'));
    }

    public function update(Request $request, Order $order) {

        if(Gate::allows('PARCEL_ADD')) {


            if($order->paid == 1){
                return $this->failure('ტრანსპორტირების ფასი უკვე გადახდილია');
            }

            $parameter = Parameter::query(); // parameter for queries

            $parcel_type = $request->get('parcel_type');

            $_validator = \Validator::make($request->only('parcel_type'), ['parcel_type'=>'required|in:personal,online']);

            if($_validator->fails()) {
                return $this->failure($_validator);
            }

            $params = $parameter->select('price_list_personal','price_list_online')->where('id',1)->get()[0];
            $personalObject = json_decode($params->price_list_personal,true);
            $onlineObject = json_decode($params->price_list_online, true);

            $_parcelType = $this->parcelType($parcel_type, $onlineObject, $personalObject);

            $rules = $_parcelType['rules'];
            $validator = \Validator::make($request->input(), $rules);
            if ($validator->fails()) {
                return $this->failure($validator);
            }

            $values = array_keys($rules);
            $all = $request->only($values);
            $active_parcel_type = $_parcelType['active_parcel_type'];
            unset($all['room_number']);

            $sender_id = $request->input('sender_id');
            $room_number = $request->input('room_number');

            // calculate price
            $weight = $request->input('weight');

            $from_country = Country::query()->find($request->input('from_country_id'));
            $to_country = Country::query()->find($request->input('to_country_id'));

            $parcel_cost = $this->calculate($weight,$from_country->code,$to_country->code, $active_parcel_type, $parcel_type);
            if($parcel_cost['success']){
                $all['parcel_cost'] = $parcel_cost['result']['parcel_cost'];

                if($request->get('home_delivery')){
                    $all['to_delivery_cost'] = round($parcel_cost['result']['to_delivery_cost'],2);
                    $all['home_delivery'] = 1;
                }

                if($request->get('from_home_delivery')){
                    $all['from_delivery_cost'] = round($parcel_cost['result']['from_delivery_cost'],2);
                }
            }else{
                return $this->failure($parcel_cost['error']);
            }

            $all['sender_id'] = $sender_id;

            if($parcel_type != 'online') {
                if (!$this->userExists($sender_id)) {
                    $response = $this->createSender($request);
                    if ($response['success']) {
                        $all['sender_id'] = $response['result']['user_id'];
                    } else {
                        return $this->failure($response['error']);
                    }
                }
                if(!$this->userExists($room_number)) {

                    $response = $this->createReceiver($request);
                    if ($response['success']) {
                        $room_number = $response['result']['user_id'];
                    } else {
                        return $this->failure($response['error']);
                    }

                }
                $all['type']='1';
            }

            // online
            if(!$this->userExists($room_number)) {

                return $this->failure(['user not exists']);

            }

            $all['user_id'] = $room_number;
            $all['operator_id'] = auth()->user()->id;
            $all['weight'] = $weight;
            $all['status'] = 'warehouse';


            $predeclared_order = [];
            if($request->has("tracking_number")) {
                $predeclared_order = Order::query()->where('tracking_number', $all['tracking_number'])
                    ->where('user_id', $room_number)
                    ->where('operator_id', null)
                    ->where('type', 0)
                    ->first();
            }
            if($request->has("tracking_number") && count($predeclared_order)) {
                if($parcel_type == 'online'){
                    $user_data = $predeclared_order->user;

                }else{
                    $all['xero_invoice_for'] == 'sender' ? $user_data = $predeclared_order->sender : $user_data = $predeclared_order->user;
                }
                $predeclared_order->update($all);


                $return_id = $predeclared_order->id;
                $xero_result = $this->createXeroInvoice($predeclared_order,$user_data);
                if($xero_result['success']){
                    $predeclared_order->xero_invoice_number = $xero_result['invoice_number'];
                    $predeclared_order->xero_payment_url = $xero_result['payment_url'];
                    $predeclared_order->save();

                }

                $this->mailToUser($predeclared_order);
                $this->msge($predeclared_order);

                return $this->success(['text'=>trans('defaults.orders.success'),'id'=>$return_id]);


            } else {

                // create order start

                $new_order = Order::query()->create($all);
                if($parcel_type != 'online'){
                    $new_order->category()->sync($all['order_category_ids']);
                }

                if($new_order->tracking_number == null) {
                    $id = (integer)'50605439800010000' + (integer)$new_order->id; // unic id
                    $tracking_number = str_pad($id, 18, '0', STR_PAD_LEFT);
                    $new_order->tracking_number = $tracking_number;
                    $new_order->save();
                }

                if($parcel_type == 'online'){
                    $user_data = $new_order->user;
                }else{
                    $all['xero_invoice_for'] == 'sender' ? $user_data = $new_order->sender : $user_data = $new_order->user;
                }

                $return_id = $new_order->id;
                $xero_result = $this->createXeroInvoice($new_order,$user_data);
                if($xero_result['success']){
                    $new_order->xero_invoice_number = $xero_result['invoice_number'];
                    $new_order->xero_payment_url = $xero_result['payment_url'];
                    $new_order->save();
                }
                if($parcel_type == 'online') {
                    $this->mailToUser($new_order);
                    $this->msge($new_order);
                }
                // end <== create

                return $this->success(['text'=>trans('defaults.orders.success'),'id'=>$return_id]);

            }

        }

        return $this->permissionDenied();
    }

    public function adminPay(Order $order) {
        if(Gate::allows('PARCEL_ADD')){


            if($order->cost <= 0) {
                return $this->failure(trans('defaults.orders.payment.prohibited'));
            }

            if($order->paid == 0) {

                $data_for_xero = [
                    'invoice_number'=>$order->xero_invoice_number,
                    'amount'=>$order->cost,
                ];
                if($order->xero_invoice_number != '' && !is_null($order->xero_invoice_number)) {
                    XeroController::pay($data_for_xero);
                }
                $priceInGel = 0;
                try {
                    $currencies = Currency::query()->where('id',1)->first()->toArray();
                    $rates = $currencies;
//                    $rates['GBPGEL'] = $rates['GBP'] / $rates['USDGBP'];
                    $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
                    if ($rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost > 0) {
                        $priceInGel = $rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost;
                        $priceInGel = round($priceInGel, 3);
                    }
                }catch (Exception $e){
//                    todo save error to errors report
                }

                if($priceInGel > 0) {
                    if ($order->user->unicard != '' && !is_null($order->user->unicard)) {
                        // todo set points with order weight

                        $unicard = $order->user->unicard;
                        $connect = UnicardController::setPoints($unicard, $priceInGel);

                        if ($connect['success']) {
                            $Ucard = new Unicard();
                            $Ucard->transporting_cost = $priceInGel;
                            $Ucard->user_id = $order->user->id;
                            $Ucard->trans_id_stan = $connect['stan'];
                            $Ucard->amount = $connect['data']['Bonus'];
                            $Ucard->status = 1;
                            $Ucard->message = $connect['data']['ResultMsg'];
                            $Ucard->save();

                        } else {

                            $Ucard = new Unicard();
                            $Ucard->transporting_cost = $priceInGel;
                            $Ucard->user_id = $order->user->id;
                            $Ucard->trans_id_stan = $connect['stan'];
                            $Ucard->status = 0;
                            $Ucard->message = @$connect['data']['ResultMsg'];
                            $Ucard->save();
                        }
                    }

                }
                $order->paid = 1;
                $order->save();

                return $this->success(trans('defaults.orders.payment.success'));



            }else{
                return $this->failure(trans('defaults.orders.payment.already_paid'));
            }

        }

        return $this->permissionDenied();
    }


    /*============================================*/

    private function mailToUser($order){

        Mail::to($order->user->email)->send(new OrderReceived($order->user,$order));

    }

    private function mailStatusUpdate($order,$message, $sms){


        if($sms) {
            $msge = new Msge();
            $msge->message = $sms;
            $msge->to = $order->user->mobile;
            $msge->send();
        }
//        return new OrderStatuses($order, $message);
        if($order->user->email != '') {
            Mail::to($order->user->email)->send(new OrderStatuses($order, $message));
        }
    }

    private function msge($order) {
        $msge = new Msge();
        $msge->message = trans('defaults.orders.sms') . $order->tracking_number. trans('defaults.orders.csms');
        $msge->to = $order->user->mobile;
        if($order->user->mobile != '') {
            $msge->send();
        }
    }

    public function msgeSandro(){
        $msge = new Msge();
        $msge->message = trans('defaults.orders.sms') . "123123495959595959". trans('defaults.orders.csms');
        $msge->to = "995599399808";
        $msge->send();
        return "success";
    }

    private function parcelType($parcel_type, $online, $personal){

        if($parcel_type == 'online') {
            $rules = [
                'room_number' => 'required|exists:users,id',
                'weight' => 'required',
                'tracking_number' => 'sometimes',
                'from_country_id' => 'required|numeric',
                'to_country_id' => 'required|numeric',
                'home_delivery' => 'sometimes|boolean',
            ];

            $active_parcel_type = $online;
        } else {
            $rules = [
                'weight' => 'required',
                'from_country_id' => 'required|numeric',
                'to_country_id' => 'required|numeric',

                'room_number' => 'sometimes|numeric',
                'sender_id' => 'sometimes|numeric',

                'order_category_ids'=>'required|array',
                'tracking_number' => 'sometimes|numeric',
                'obtain_cost'=>'sometimes|required',
                'obtain_currency'=>'sometimes|required',
                'obtain_webstore'=>'sometimes|required',
                'address_1'=>'sometimes|required',
                'city_town'=>'sometimes|required',
                'address'=>'sometimes|required',
                'comment'=>'sometimes|required',

                'sender'=>'sometimes|array',
                'receiver'=>'sometimes|array',
                'xero_invoice_for'=>'required',
                'from_home_delivery' => 'sometimes',
                'home_delivery'=>'sometimes'
            ];
            $active_parcel_type = $personal;
        }

        return [
            'rules'=>$rules,
            'active_parcel_type' => $active_parcel_type
        ];
    }

    private function calculate($weight,$from_country,$to_country, $active_parcel_type, $parcel_type){


        $data = array_first($active_parcel_type, function($item) use($from_country, $to_country) {
            return $item['from']==$from_country&&$item['to']==$to_country;
        });
        $result = [];
        if(is_array($data) && isset($data['prices'])) {
            $pList = $data['prices'];
            foreach ($pList as $priceObj){


                // weight = 1.5
                // 0 - 2kg
                //
                //0 - 0.75
                //0.75 - 5 = 3.5
                //3.5 * 0.8
                if($priceObj['from'] < $weight && ($priceObj['to'] >= $weight || $priceObj['to']=='Infinity') ) {
                    $price = $priceObj['price'] * $weight;
                    $result['parcel_cost'] = $price;
                    if($price < $data['minPrice']) {
                        $result['parcel_cost'] = $data['minPrice'];
                    }
                    break;
                }
            }

            if($parcel_type == 'online'){

                foreach($data['home_delivery'] as $prices) {
                    if($prices['from'] < $weight && ($prices['to'] >= $weight || $prices['to']=='Infinity') ) {
                        $result['to_delivery_cost'] = $prices['price'];
                        $result['from_delivery_cost'] = 0;
                    }
                }

            }else{
                $result['from_delivery_cost'] = $data['from_home_per_kg'] * ($weight < 1 ? 1 : $weight);
                $result['to_delivery_cost'] = $data['home_delivery_per_kg'] *  ($weight < 1 ? 1 : $weight);
            }
//dd($result);
            return [
                'success'=>true,
                'result'=>$result,
                'error'=>''
            ];

        }

        return [
            'success'=>false,
            'result'=>'',
            'error'=>trans('defaults.orders.weight_problem')
        ];



    }

    private function createOrder($all, $parcel_type){
        return false;
    }

    private function createSender(Request $request) {

        $rules = [
            'name'=>'required',
            'surname' => 'required',
            'email' => 'sometimes|email',
            'mobile' => 'sometimes|required'
        ];

        $result = [];
        $_validator = Validator::make($request->get('sender'), $rules);

        if($_validator->fails()) {

            $result['success'] = false;
            $result['error'] = $_validator->messages();

        } else {

            $user_id = User::query()->create(
                array_merge($request->get('sender'),[
                    'temp'=>1,
                    'country_id'=>$request->get('from_country_id')
                    ]
            ))->id;

            $result = [
                'success' => true,
                'result' => ['user_id' => $user_id ]

            ];
        }

        return $result;

    }

    private function createReceiver(Request $request) {

        $rules = [
            'name'=>'required',
            'surname' => 'required',
            'email' => 'sometimes|email|unique:users,email',
            'mobile' => 'sometimes|required'
        ];

        $result = [];
        $_validator = Validator::make($request->input('receiver'), $rules);

        if($_validator->fails()) {

            $result['success'] = false;
            $result['error'] = $_validator->messages();

        } else {

            $user_id = User::query()->create(
                array_merge($request->get('receiver'),[
                    'temp'=>1,
                    'country_id'=>$request->get('to_country_id')
                ])
            )->id;

            $result = [
                'success' => true,
                'result' => ['user_id' => $user_id ]

            ];
        }

        return $result;

    }

    private function userExists($id) {
        return User::query()->find($id) !== null;
    }

    private function createXeroInvoice($all,$user_data) {
//
//        return [
//            'success'=>false
//        ];
        $result = XeroController::create($all,$user_data);
        return $result;

    }

    public function recreateXeroInvoice() {

        // todo user this function on xero invoice job - or failed job
        return $this->permissionDenied();
        $orders = Order::query()->with('sender')->where('id','>' , 3657)->where('xero_invoice_number',null)->where('type',1)->get(); //when sender private parcel


        if($orders->count()){
            foreach($orders as $order ) {
                $result = XeroController::create($order,$order->sender); // private
//                $result = XeroController::create($order,$order->user); // online
                if($result['success']){
                    $order->xero_invoice_number = $result['invoice_number'];
                    $order->xero_payment_url = $result['payment_url'];
                    $order->xero_guid = $result['xero_guid'];
                    $order->save();

                }

            }
        }

    }

    private function payXeroInvoice($data) {
        $result = XeroController::create($data); // invoice_number
        return $result;
    }

    public function adminDelete($order){

        if(Gate::allows('PARCEL_ADD') && (auth()->user()->id == 1 || auth()->user()->id == 3)){

            $o = Order::query()->where('id',$order)->first();

            $data = [
                'action'=>'Delete ',
                'title'=>'Order Deleted',
                'description'=>'Deleted [ order id = '.$order.' ] | [ Tracking: '.$o->tracking_number." ] | [ Xero: ".$o->xero_invoice_number. "  ] | [ paid ". $o->paid ." ] | [ Owner: ".$o->user->name. " ] | [ Owner KW: ".$o->user->id." ]",
                'user'=>auth()->user()->name,
                'user_id'=>auth()->user()->id,
                'time'=>Carbon::now()->timezone('Asia/Tbilisi'),
                'user_email'=>auth()->user()->email
            ];

            $o->delete();
            Mail::to('warn-actions@antidze.com')->send(new WarningMails($data));

            return $this->success('Success');

        }
        return $this->permissionDenied();
    }



    public function updateXero(){

        $order = Order::query()->where('id',6177)->first();

        $xero = XeroController::update($order);

        dd($xero);
    }
}
