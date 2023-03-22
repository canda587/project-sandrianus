<?php

namespace App\Models;


class RajaOngkir 
{
    private static $api_key = "b486094202b96d226c1971250ba94c95";

    private static function config($url = "https://api.rajaongkir.com/starter/province", $method = "GET",$body=null){
         $curl = curl_init();
            $set_curl = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => [
                    "key:".self::$api_key
                ],
            ];

        if($method == "POST"){
            $set_curl[CURLOPT_POSTFIELDS] = $body;
            array_push($set_curl[CURLOPT_HTTPHEADER],"content-type: application/x-www-form-urlencoded");
        }

        curl_setopt_array($curl, $set_curl);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }



    public static function get_province(){
        return static::config();
    }

    public static function get_city($id){
        return static::config("https://api.rajaongkir.com/starter/city?province=".$id);
    }
    public static function get_service($origin,$destination,$weight,$courier){
        $body = 'origin='.$origin.'&destination='.$destination.'&weight='.$weight.'&courier='.$courier;

        return static::config('https://api.rajaongkir.com/starter/cost',"POST",$body);

    }
}
