<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

class UnicardController extends Controller
{
    //

    const METHOD = 'aes-256-cbc';
    private static $UserId = 'KIWIPOST', $password='KIWIPOST'; // real
//    private static $UserId = 'KIVIPOST', $password='KIVIPOST'; // test

    public static function connect($servicename, $parameters = false)
    {

        $ch = curl_init('http://92.241.68.214:9000/UniProcessing.Service1.svc/' . $servicename); // real
//        $ch = curl_init('http://92.241.68.213:9000/UniProcessing.Service1.svc/' . $servicename); // test


        $parameters = json_encode($parameters, JSON_UNESCAPED_UNICODE);
        $signed_msg = self::encrypt(md5($parameters), base64_decode(config('defaults.unicard.privateKey')));

        // ჰეშირება (security)
        $array = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($parameters),
            'HTTP-Verb: POST',
            'x-auth-client: ' . config('defaults.unicard.client'),
            'x-auth-message: ' . $signed_msg['message'],
            'x-auth-nonce: ' . $signed_msg['iv']
        ];

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $array);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $result = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $result = substr($result, $header_size);


        curl_close($ch);
        return json_decode($result, true);

    }

    public static function encrypt($message, $key)
    {
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivsize);

        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return [
            'iv' => base64_encode($iv),
            'message' => base64_encode($ciphertext)
        ];
    }


    public static function getAccountInfo($unicard){
        $gustan = self::guidv4();
        if($unicard){
            $connect = self::connect('GetAccountInfo', [
                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'centre' => '61'
            ]);
        }
        // 1199110301814963

        if(@$connect['Result']==101){
            return [
                'success'=>false,
                'data'=>$connect
            ];
        }
        
        return [
            'success'=>true,
            'data'=>$connect
        ];


    }

    public static function setPoints($unicard,$amount){

        $now = Carbon::now()->format('d/m/Y H:m:s');
        $gustan = self::guidv4();
        if($unicard){
            $connect = self::connect('OnlineMerch_MakeTran', [
                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'amount' => $amount,
                'terminal_id' => 'KIWIPOST',
                'merchant_id' => 'KIWIPOST',
                'auth_code' =>  $now,
                'tranz_type' => '1',
                'centre' => '61',
                'batch_id' => $now,
                'auth_date_time' => $now,
                'resp_code' => '000',
                'stan' => $gustan,
            ]);

            if($connect['Result']==200){

                return [
                    'success'=>true,
                    'data'=>$connect,
                    'stan'=>$gustan
                ];
            }else{
                return [
                    'success'=>false,
                    'data'=>$connect,
                    'stan'=>$gustan,
                ];
            }

        }

        return [
            'success'=>false
        ];
    }

    public static function setBonuse($unicard){

        $now = Carbon::now()->format('d/m/Y H:m:s');

        $gustan = self::guidv4();
        if($unicard){
            $connect = self::connect('OnlineMerch_MakeTran', [
                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'amount' => 20,
                'terminal_id' => 'KIWIPOSTBON',
                'merchant_id' => 'KIWIPOSTBON',
                'auth_code' =>  $now,
                'tranz_type' => '1',
                'centre' => '61',
                'batch_id' => $now,
                'auth_date_time' => $now,
                'resp_code' => '000',
                'stan' => $gustan,
            ]);

            if($connect['Result']==200){

                return [
                    'success'=>true,
                    'data'=>$connect,
                    'stan'=>$gustan,
                ];
            }else{
                return [
                    'success'=>false,
                    'data'=>$connect,
                    'stan'=>$gustan,
                ];
            }

        }

        return [
            'success'=>false
        ];
    }

    public static function payFromUnicardStepFirst($unicard,$amount) {
        $now = Carbon::now()->format('d/m/Y H:m:s');
        $gustan = self::guidv4();
        // $stan = ;
        if($unicard){
            $connect = self::connect('OnlineMerch_MakePayment', [
                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'amount' => $amount,
                'merchant_id' => 'KIWIPOST',
                'terminal_id' => 'KIWIPOST',
                'centre' => '61',
                'auth_date_time' => $now,
                'resp_code' => '001',
                'request_otp'=>"1",
                'batch_id' => $now,
                'stan' => $gustan,

            ]);

            if($connect['Result']==200){

                return [
                    'success'=>true,
                    'data'=>$connect,
                    'stan'=>$gustan
                ];
            }else{
                return [
                    'success'=>false,
                    'data'=>$connect
                ];
            }

        }
        // 'auth_code' =>  'tran_unique_identifier000',
        // 'tranz_type' => '1',
        return [
            'success'=>false
        ];
    }

    public static function resendSmsCode($unicard,$amount,$stan){

        $now = Carbon::now()->format('d/m/Y H:m:s');
        $gustan = self::guidv4();
        // $stan = ;
        if($unicard){
            $connect = self::connect('SendOTP', [
                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'amount' => $amount,
                'merchant_id' => 'KIWIPOST',
                'terminal_id' => 'KIWIPOST',
                'centre' => '61',
                'auth_date_time' => $now,
                'resp_code' => '001',
                'request_otp'=>"1",
                'batch_id' => $now,
                'stan' => $gustan,

            ]);

            if($connect['Result']==200){

                return [
                    'success'=>true,
                    'data'=>$connect
                ];
            }else{
                return [
                    'success'=>false,
                    'data'=>$connect
                ];
            }

        }
        // 'auth_code' =>  'tran_unique_identifier000',
        // 'tranz_type' => '1',
        return [
            'success'=>false
        ];
    }

    public static function payFromUnicardStepTwo($unicard, $amount, $sms, $stan) {
        $now = Carbon::now()->format('d/m/Y H:m:s');
        if($unicard != '' & $sms != ''){
            $connect = self::connect('OnlineMerch_MakePayment', [

                'UserId' => self::$UserId,
                'Password' => self::$password,
                'card' => $unicard,
                'amount' => $amount,
                'merchant_id' => 'KIWIPOST',
                'terminal_id' => 'KIWIPOST',
                'centre' => '61',
                "auth_date_time"=> $now,
                "resp_code" => "000",
                "request_otp" => "1",
                'batch_id' => $now,
                'stan' => $stan,
                "otp"=> $sms

            ]);


            if($connect['Result']==200){

                return [
                    'success'=>true,
                    'data'=>$connect
                ];
            }else{
                return [
                    'success'=>false,
                    'data'=>$connect
                ];
            }
        }
        return [
            'success'=>false
        ];
    }

    public static function guidv4()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }



}
