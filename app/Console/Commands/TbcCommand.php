<?php

namespace App\Console\Commands;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use \Illuminate\Http\Request;
use WeAreDe\TbcPay\TbcPayProcessor;

class TbcCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tbc:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command syncs payments (TBC Only) between user and website';

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
    public function handle(Request $request)
    {


        $time = Carbon::createFromTime()->subMinute(40);


        $payments = Payment::query()->with('user')->where('status_code', null)->where('created_at', '<', $time->toDateTimeString())->get();

        if($payments->count()) {



            $cert_path = storage_path('cert/kiwiposttbc.pem');
            $cert_pass = 'kiwipostuklondon';

            foreach ($payments as $payment) {


                $ip = $request->ip();

                $tbc_payment = new TbcPayProcessor($cert_path, $cert_pass, $ip);
                $tbc_status = $tbc_payment->get_transaction_result($payment->transaction_id);

                if($tbc_status['RESULT'] == 'OK' && $tbc_status['RESULT_CODE'] == '000') {

                    $status = $tbc_status['RESULT_CODE'];
                    $payment->status_code = $status;
                    $balance = round(($payment->user->balance + $payment->amount), 2);
                    $payment->user->update(['balance' => $balance]);
                    $payment->save();
                    $this->info('success of payment info updated!!! trans_id = '. $payment->transaction_id);

                }else{
                    $this->info('failure payment status is 999 trans_id = '. $payment->transaction_id);
                    $payment->status_code = '999';
                    $payment->save();
                }


            }

        }else{
            $this->info('nothing to count');
        }

    }
}
