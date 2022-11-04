<?php
/**
 * Created by PhpStorm.
 * User: sandroantidze
 * Date: 11/9/17
 * Time: 12:19 AM
 */

namespace App\Classes;


class Msge
{

    private $username = 'kivipost';

    private $passowrd = '7h47fgddtg';

    private $client_id = 380;

    private $service_id = '0380';

    private $url = 'http://msg.ge/bi/sendsms.php';

    public $message = '';

    public $to = '';


    public function send() {
        $http = new \GuzzleHttp\Client;
        $url = "$this->url?username=$this->username&password=$this->passowrd&client_id=$this->client_id&service_id=$this->service_id&to=$this->to&text=$this->message";
        return $http->get($url)->getBody();




    }

}