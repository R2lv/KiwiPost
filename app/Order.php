<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\XeroController;


use App\Http\Controllers\UnicardController;
use App\Unicard;

class Order extends Model
{
    //

    protected $fillable = [
        'user_id','operator_id','sender_id','from_country_id','to_country_id','trusted_id',
        'tracking_number','type','home_delivery','deny','obtain_cost','obtain_currency','obtain_invoice','obtain_webstore','obtain_categories','status',
        'parcel_cost','delivery_cost','paid','weight','xero_payment_url','xero_invoice_number','xero_guid','comment','from_delivery_cost','to_delivery_cost','xero_invoice_for','unicard_amount','unicard_unique_id'
    ];


    protected $appends = ['cost','order_category_ids','is_paid'];

    public function getCostAttribute() {

            return $this->parcel_cost + $this->from_delivery_cost + $this->to_delivery_cost;
    }
    
    public function getIsPaidAttribute() {
        if(auth()->user()->roles == 0) {
            if ($this->paid == 0 && $this->cost != 0 && !is_null($this->xero_invoice_number) && !empty($this->xero_invoice_number)) {
                $invoice = $this->xero_invoice_number;
                $data = [
                    'invoice_number' => $invoice
                ];
//                $result = XeroController::check($data);
//            return $result;
//                $result['success'] = false;
//                if ($result['success']) {
//                    $this->update(['paid' => 1]);
//
//                    $priceInGel = 0;
//                    try {
//                        $currencies = new Currency;
//                        $rates = $currencies->get()['quotes'];
//                        $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
//                        $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
//                        if ($rates[$this->obtain_currency . 'GEL'] * $this->parcel_cost > 0) {
//                            $priceInGel = $rates[$this->obtain_currency . 'GEL'] * $this->parcel_cost;
//                            $priceInGel = round($priceInGel, 3);
//                        }
//                    } catch (Exception $e) {
////                    todo save error to errors report
//                    }
//
//
//                    if ($this->user->unicard != '' && !is_null($this->user->unicard)) {
//                        // todo set points with order weight
//                        $unicard = $this->user->unicard; //
//                        $connect = UnicardController::setPoints($unicard, $priceInGel);
//
//                        if ($connect['success']) {
//                            $Ucard = new Unicard();
//                            $Ucard->transporting_cost = $priceInGel;
//                            $Ucard->user_id = $this->user->id;
//                            $Ucard->trans_id_stan = $connect['stan'];
//                            $Ucard->amount = $connect['data']['Bonus'];
//                            $Ucard->status = 1;
//                            $Ucard->message = $connect['data']['ResultMsg'];
//                            $Ucard->save();
//
//                        } else {
//
//                            $Ucard = new Unicard();
//                            $Ucard->transporting_cost = $priceInGel;
//                            $Ucard->user_id = $this->user->id;
//                            $Ucard->trans_id_stan = $connect['stan'];
//                            $Ucard->status = 0;
//                            $Ucard->message = @$connect['data']['ResultMsg'];
//                            $Ucard->save();
//                        }
//                    }
//
//
//                    return 1;
//                }
            }
        }
        return $this->paid;
    }

    public function user(){

        return $this->belongsTo(User::class);

    }

    public function operator(){

        return $this->belongsTo(User::class,'operator_id','id');

    }

    public function fromCountry(){

        return $this->belongsTo(Country::class,'from_country_id','id');

    }

    public function toCountry(){

        return $this->belongsTo(Country::class,'to_country_id','id');

    }

    public function category() {
        return $this->belongsToMany(Category::class,'order_categories');
    }

    public function getOrderCategoryIdsAttribute() {
        return array_map(function($cat) {
            return $cat["pivot"]["category_id"];
        }, $this->category->toArray());
    }

    public function trustedUser() {

        return $this->belongsTo(TrustedList::class,'trusted_id');

    }

    public function sender() {

        return $this->belongsTo(User::class,'sender_id','id');

    }

}
