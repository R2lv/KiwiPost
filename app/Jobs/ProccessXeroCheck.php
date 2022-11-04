<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\XeroController;
use App\Order;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarningMails;
use Carbon\Carbon;


class ProccessXeroCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $xero_data;

    public $tries = 75;
    public $timeout = 120;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->xero_data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Log::debug("=======================");
        Log::debug('Webhook recieved resourceId =  '.json_encode($this->xero_data[0]['resourceId']));
        Log::debug("=======================");
        if(count($this->xero_data)) {

            if ($this->xero_data[0]['resourceId'] !== "") {
                $result = XeroController::resource($this->xero_data[0]['resourceId']);
                Log::debug("Xero data is checked");
                Log::debug("=======================");
                if ($result['success']) {
                    $data = [
                        'action' => 'Delete ',
                        'title' => 'Xero API CAlls',
                        'description' => " Updated by xero call" . " ". json_encode($this->xero_data) ,
                        'user' => "Xero.com",
                        'user_id' => "Some User",
                        'time' => Carbon::now()->timezone('Asia/Tbilisi'),
                        'user_email' => "email@email.com"
                    ];
                    Log::debug("Xero data Succeed");
//                    Mail::to('warn-actions@antidze.com')->send(new WarningMails($data));

                    Log::debug('test 1');

                    if($result['data']['Status'] == 'PAID') {
                        Log::debug("Is Paid");
                        Log::debug("=======================");
                        $order = Order::query()->where('xero_invoice_number', $result['data']['InvoiceNumber'])->where('paid',0)->first();
                        if($order){
                            Log::debug("Kiwi Order price has been updated invoice number is ". $result['data']['InvoiceNumber']);
                            $order->paid = 1;
                            $order->save();
                        }else{
                            Log::debug("Kiwi Order Not Updated ");
                        }
                    }


                } else {
                    Log::debug('Failed not success');
                }
            } else {

                Log::debug('Failed no resourceId');
            }
        }else {
            Log::debug("Failed not even started");
        }
    }
}
