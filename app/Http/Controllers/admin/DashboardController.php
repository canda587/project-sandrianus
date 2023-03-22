<?php

namespace App\Http\Controllers\admin;
use App\Models\Item;
use App\Models\Category;
use App\Models\Order;
use App\Models\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'title' => "Dashboard",
            'item' => Item::all(),
            'item_stock' => Item::whereBetween("item_stock",[0,10])->get(),
            'category' => Category::all(),
            'order' => Order::whereBetween("status_id",[1,3])->get(),
            'new_order' => Order::whereBetween("status_id",[1,2])->get(),
            'transaction' => Transaction::all()
        ];

        return view('pages/admin/index',$data);
       
    }


    public function test(){


        return response()->json("oke oke",200);
    }
}
