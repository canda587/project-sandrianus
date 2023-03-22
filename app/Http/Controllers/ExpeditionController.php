<?php

namespace App\Http\Controllers;
use App\Models\RajaOngkir;
use Illuminate\Http\Request;

class ExpeditionController extends Controller
{
    public function get_service(Request $request){
        $check_service = json_decode(RajaOngkir::get_service($request->origin,$request->destination,$request->weight,$request->courier),true);

        if($check_service['rajaongkir']['status']['code'] == 200){
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => $check_service['rajaongkir']['results'][0]['costs']
            ];
        }
        else{
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $check_service['rajaongkir']['status']['description']
            ];
            $result = "sorry there is no service at your address";
        }
        return response()->json($send_json,$status_code);
    }
}
