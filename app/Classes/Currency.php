<?php
/**
 * Created by PhpStorm.
 * User: sandroantidze
 * Date: 11/10/17
 * Time: 3:21 PM
 */

namespace App\Classes;

use SoapClient;
use GuzzleHttp\Client;

class Currency
{

    private $access_key = "08eed146677ad4d901cb702d388ea3d5",
        $source = "USD",
        $currencies = [
            'GBP','GEL','EUR'
        ];

//    private $urlPattern = "http://www.apilayer.net/api/live?access_key=%s&source=%s&currencies=%s";
    private $urlPattern = "http://nbg.gov.ge/currency.wsdl";

    public function get() {

//        $url = sprintf($this->urlPattern, $this->access_key, $this->source, implode(",", $this->currencies));
//        $http = new Client();
//        $response = json_decode($http->get($url)->getBody(), true);
//        $response['quotes']['USDGBP'] = $response['quotes']['USDGBP'] - 0.015;
//



        $result = [];

        $client = new SoapClient('http://nbg.gov.ge/currency.wsdl');
        $result['quotes']['USDEUR'] = $client->GetCurrency('USD') / $client->GetCurrency('EUR');


        $result['quotes']['USDGBP'] = ($client->GetCurrency('USD') / $client->GetCurrency('GBP'));
        $result['quotes']['USDGEL'] = $client->GetCurrency('USD');
        $result['quotes']['GBPUSD'] = $client->GetCurrency('GBP') / $client->GetCurrency('USD');
        $result['quotes']['GBPGEL'] = $client->GetCurrency('GBP') + 0.015;
        $result['quotes']['GELGBP'] = (1/$client->GetCurrency('GBP')) - 0.015;




        return $result;

    }

}