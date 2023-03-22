<?php

namespace App\Http\Controllers;
use App\Models\RajaOngkir;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class RegionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function all_province(){
         $check_province = json_decode(RajaOngkir::get_province(),true);    

        if($check_province){
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => $check_province['rajaongkir']['results']
            ];
        }
        else{
            $status_code = 400;
            $send_json = [
                'success' => false,
                'response' => "Your internet connection may be bad, please check again."
            ];
        }


        return response()->json($send_json,$status_code);
    }

     public function all_city(Request $request){

        $check_city = json_decode(RajaOngkir::get_city($request->province),true);    

        if($check_city){
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => $check_city['rajaongkir']['results']
            ];
        }
        else{
            $status_code = 400;
            $send_json = [
                'success' => false,
                'response' => "Your internet connection may be bad, please check again."
            ];
        }


        return response()->json($send_json,$status_code);
    }

    public function get_region(Request $request){
        $region = auth()->user()->region;

        $check_province = json_decode(RajaOngkir::get_province(),true);
        $check_city = json_decode(RajaOngkir::get_city($region->province_code),true);


        if($check_province && $check_city){
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => [
                    'region_code' => auth()->user()->region_code,
                    'province_code' => $region->province_code,
                    'city_code' => $region->city_code,
                    'address_detail' => $region->address_detail,
                    'province' => $check_province['rajaongkir']['results'],
                    'city' => $check_city['rajaongkir']['results']
                ] 
            ];
        }
        else{
            $status_code = 400;
            $send_json = [
                'success' => false,
                'response' => "Your internet connection may be bad, please check again."
            ];
        }

        return response()->json($send_json,$status_code);
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'province_code' => 'required|numeric',
            'city_code' => 'required|numeric',
            'province_name' => 'required',
            'city_name' => 'required',
            'address_detail' => 'required'
        ]);


        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your input is wrong, check the add address form again"
            ];
        }
        else{
            $user = auth()->user()->id_user;
            $set_random = Str::random(4);
            $code = Str::of("ADR-".$user."-".$set_random)->upper();
    
            $set_data = $validator->validate();
            $set_data['code'] = $code;

            Region::create($set_data);

            User::where("id_user",$user)
                ->update(['region_code' => $code]);



            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "Address has been successfully added",
                
                
            ];
        }

        return response()->json($send_json,$status_code);
    }

    public function update(Request $request, Region $region){

        $validator = Validator::make($request->all(),[
            'province_code' => 'required|numeric',
            'city_code' => 'required|numeric',
            'province_name' => 'required',
            'city_name' => 'required',
            'address_detail' => 'required'
        ]);


        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your input is wrong, check the add address form again"
            ];
        }
        else{
            
    
            $set_data = $validator->validate();
           

            Region::where("id_region", $region->id_region)
                    ->update($set_data);
        
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "The address has been successfully updated",
                
                
            ];
        }

        return response()->json($send_json,$status_code);
    }


    public function destroy(Region $region){
        Region::destroy($region->id_region);

        User::where("id_user",auth()->user()->id_user)
            ->update(['region_code' => null]);
        $send_json = [
            'success' => true,
            'response' => "The address has been successfully Deleted",
        ];
        

        return response()->json($send_json,200);
    }
}
