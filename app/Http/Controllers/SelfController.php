<?php

namespace App\Http\Controllers;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SelfController extends Controller
{
    
    public function update(User $user,Request $request){

        $validator = Validator::make($request->all(),[
            'name' => "required",
            'phone_number' => "required"
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => "Your input is wrong, please check your update user form again",
                'fail' => $validator->messages()
            ];
        }
        else{
            $set_data = $validator->validate();
            User::where("id_user",$user->id_user)
                ->update($set_data);

            $status_code = 200;
             $send_json = [
                'success' => true,
                'response' => "Your personal data has been successfully updated",
                'is_admin' => $user->is_admin
                
            ];
        }


        return response()->json($send_json,$status_code);
    }

}
