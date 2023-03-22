<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemTest;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Apriori;
use App\Models\RajaOngkir;
use App\Models\DataTester;
class HomeController extends Controller
{   
    private $apriori;

    public function __construct(){
        // parent::__construct();

        $transactions = DataTester::transaction();

        $items = Item::all()->toArray();
        $apriori = new Apriori($transactions,$items,"slug");
        $this->apriori = $apriori;

    }

    public function index(){
        $item = Item::filter(request(['category']))->where("item_stock",">",0)->paginate(10)->withQueryString();

        
        $data = [
            'title' => "Home",
            'recommendation' => $this->apriori->frekuensi_data(),
            'carousels' => ItemTest::all_carousel(),
            'items' => $item,
            'categories' => Category::filter()->get()
        ];
        return view('pages/home/index',$data);
    }

    public function detail(Item $item){
        $get_admin = User::firstWhere("is_admin",1);
       

        if(!auth()->user()){
            $destination = null;
        }else{
             $destination = auth()->user()->region;
             if(!$destination){
                $destination = null;
             }
             else{
                $destination = $destination->city_code;
             }
            
        }
        

        
        $data = [
                'title' => "Detail | ". $item->item_name,
                'item' => $item,
                'recommendation' => collect($this->apriori->find_apriori_data($item->slug)),
                'origin' => $get_admin->region->city_code,
                'destination' => $destination
            ];
        return view('pages/home/detail',$data);
    }

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

        $check_province = json_decode(RajaOngkir::get_city($request->province),true);    

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



}
