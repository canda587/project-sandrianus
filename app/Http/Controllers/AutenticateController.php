<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AutenticateController extends Controller
{
    
    public function index(){
        $data = [
            'title' => "Autenticate"
        ];
        return view('pages/auth/index',$data); 
    }

   


    public function autenticate(Request $request){
        // $credentials = $request->validate([
        //     'email' => ['required', 'email:dns'],
        //     'password' => ['required'],
        // ]);

        $validator = Validator::make($request->all(),[
            'email' => "required|email",
            'password' => "required",
        ]);

        if($validator->fails()){
            
            return back()->withErrors($validator, 'validate_fail')->withInput();
        }
        else{

            if(Auth::attempt($validator->validate())){
                $request->session()->regenerate();
                if(auth()->user()->is_admin){
                    return redirect()->intended("/admin");
                }
                else{
                    return redirect()->intended("/");
                }

            }
            else{
                return back()->with("auth_fail","Login Fail")->withInput();
            }

        }
  
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();


        $send_json = [
            'success' => true,
            'response' => 'You have logged out, until the number again'
        ];
        $status_code = 200;

        return response()->json($send_json,$status_code);
    }

}
