<?php

namespace App\Http\Controllers\user;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Apriori;
use App\Models\Cart;
use App\Models\User;
use App\Models\Item;
use App\Models\DataTester;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $apriori;

    public function __construct(){

        $transactions = DataTester::transaction();

        $items = Item::all()->toArray();
        $apriori = new Apriori($transactions,$items,"slug");
        $this->apriori = $apriori;

    }

    public function index()
    {
        $data = [
            'title' => "Cart",
            'carts' => Cart::where("user_id",auth()->user()->id_user)->get()
        ];
        return view('pages/user/cart/index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $item = Item::where("id_item",$request->item_id)
                ->first();

        $validator = Validator::make($request->all(),[
            'item_id' => 'required|numeric',
            'cart_count' => 'required|numeric|min:1|max:'.$item->item_stock
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages()
            ];
        }
        else{

            $cart_check = Cart::where("item_id",$request->item_id)
                            ->where("user_id",auth()->user()->id_user)
                            ->first();
            $set_data = $validator->validate();
            $set_data['user_id'] = auth()->user()->id_user;
            if($cart_check){
                $set_data['cart_count'] = $cart_check->cart_count + $request->cart_count;
                
                Cart::where('id_cart',$cart_check->id_cart)
                    ->update($set_data);

            }
            else{
                Cart::create($set_data);
            }

            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "Product ".$item->item_name." has been added to your Cart"
            ];
        }


        return response()->json($send_json,$status_code);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $item = Item::where("id_item",$cart->item_id)
                ->first();

        $validator = Validator::make($request->all(),[
           
            "cart_count" => "required|numeric|min:1|max:".$item->item_stock
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages()
            ];
        }
        else{
            Cart::where("id_cart",$cart->id_cart)
                ->update($validator->validate());

            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "update successfuly"
            ];
        }   
        return response()->json($send_json,$status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {   
        Cart::destroy($cart->id_cart);

        $status_code = 200;
        $send_json = [
            "success" => true,
            "response" => "delete successfuly"
        ];

        return response()->json($send_json,$status_code);
        
    }

    public function get_list(){
        $cart = Cart::with("item")->where("user_id",auth()->user()->id_user)->get();

        return response()->json($cart->makeHidden('attribute')->toArray(),200);
    }

    public function delete_all(){
        Cart::where("user_id",auth()->user()->id)->delete();
        $send_json = [
            "success" => true,
            "response" => "delete successfuly"
        ];

        return response()->json($send_json,200);
    }

    public function checkout(){
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

        $carts = Cart::where("user_id",auth()->user()->id_user)->get();
        $items = $carts->pluck('item');
        $find = $items->implode('slug', '|');

        
        $data = [
            'title' => "Cart",
            'carts' => $carts,
            'recommendation' => $this->apriori->find_apriori_data($find),
            'destination' => $destination,
            'origin' => $get_admin->region->city_code
        ];
        return view('pages/user/cart/checkout',$data);
    }
}
