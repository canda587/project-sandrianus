<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\models\User;
class RegisterController extends Controller
{
    public function index(){
        $data = [
            'title' => "Register"
        ];
        return view('pages/auth/regis',$data);
    }

    public function store(Request $request){

       

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|max:250',
            'phone_number' => 'required|max:20',
            'password' => 'required|max:250|min:6',
            'confirm_password' => 'required|same:password|min:6'
        ]);

        if ($validator->fails()) {
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your input is wrong, please check the registration form again."  
            ];
           
        } else {
            $data = $validator->validate();
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "Registration has been successful, please login",
            ]; 
        }
        return response()->json($send_json,$status_code);
    }
}
