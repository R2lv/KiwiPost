<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use SoapClient;
use App\Currency;

class UpdateCurrencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 75;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug("=======================");
        Log::debug('Beggining scraping data from currencies provider ');
        Log::debug("=======================");



        $client = new SoapClient('http://nbg.gov.ge/currency.wsdl');

        $currency = Currency::find(1);

        $currency->USDEUR = $client->GetCurrency('USD') / $client->GetCurrency('EUR');
        $currency->USDGBP = $client->GetCurrency('USD') / $client->GetCurrency('GBP');

        $currency->USDGEL = $client->GetCurrency('USD');
        $currency->GBPUSD = $client->GetCurrency('GBP') / $client->GetCurrency('USD');

        $currency->GBPGEL = $client->GetCurrency('GBP') + 0.015;
        $currency->GELGBP = (1/$client->GetCurrency('GBP')) - 0.015;

        $currency->GELEUR = 1/$client->getCurrency('EUR');
        $currency->GELUSD = 1/$client->getCurrency('USD');
        $currency->EURGEL = $client->getCurrency('EUR');

        $currency->EURUSD = $client->GetCurrency('EUR') / $client->GetCurrency('USD');
        $currency->EURGBP = $client->GetCurrency('EUR') / $client->GetCurrency('GBP');
        $currency->save();

        Log::debug('Ending scraping data from currencies provider Success');
    }
}
