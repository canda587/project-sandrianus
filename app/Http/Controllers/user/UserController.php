<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $data = [
            'title' => "User",
        ];
        return view('pages/user/index',$data);
    }

    public function detail($param){
        $data = [
            'title' => "Detail",
            'item' => Item::find($param)
        ];
        return view('pages/home/detail',$data);
    }
}
