<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use App\Http\Controllers\XeroController;
use App\Http\Controllers\UnicardController;
use App\Currency;

class XeroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xero:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command syncs Xero invoice updates with our system. Only unpaid shipments will be triggered';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {








//        $orders = Order::query()->with(['user'])->where('paid',0)->where('status','!=','waiting')->get();
$orders = [];
//        dd($orders->count());
//        $orders = Order::query()->with(['user'])->where('id',3379)->get();
        if($orders->count()){

//            if($orders->count() >= 60) {
                $counter = 59;
  //          }
            foreach ($orders as $order) {

                if($counter == 1) {
                    continue;
                }
                $counter--;

                $xeroIsPaid = false;

                if ($order->paid == 0 && $order->cost != 0 && !is_null($order->xero_invoice_number) && !empty($order->xero_invoice_number)) {
                    $invoice = $order->xero_invoice_number;
                    $data = [
                        'invoice_number' => $invoice
                    ];
                    $result = XeroController::check($data);

                    if ($result['success']) {

                        $xeroIsPaid = true;

                    }

                    if($xeroIsPaid) {
                        $order->update(['paid' => 1]);

                        $priceInGel = 0;
                        try {
                            $currencies = Currency::query()->where('id',1)->first()->toArray();
                            $rates = $currencies;
//                            $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
                            $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
                            if ($rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost > 0) {
                                $priceInGel = $rates[$order->obtain_currency . 'GEL'] * $order->parcel_cost;
                                $priceInGel = round($priceInGel, 3);
                            }
                        } catch (Exception $e) {
//                    todo save error to errors report
                        }


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
                }
            }

        }





        $this->info('Daily Xero sync has been finished successfully');


    }
}
