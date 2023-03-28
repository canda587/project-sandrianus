<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ListOrder;
use App\Models\ListTransaction;
use App\Models\Expedition;
use App\Models\Item;
use App\Models\User;
use App\Models\Cart;
use App\Models\ProofPayment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct(){
        date_default_timezone_set("Asia/Jakarta");
    }

    private function addToTransaction($order){

        $set_transaction = [
            'code' => $order->code,
            'user_id' => $order->user_id,
            'status_id' => $order->status_id,
            'transaction_image' => $order->order_image,
            'transaction_total' => $order->order_total,
            'created_at' => $order->created_at,
            'updated_at' => $order->update_at,
        ];

        $set_list = [];
        foreach ($order->list_order as $list) {
            $set_row = [
                'transaction_code' => $order->code,
                'item_id' => $list->item_id,
                'transaction_count' => $list->order_count,
                'transaction_price' => $list->order_price,
                'transaction_sub_total' => $list->order_sub_total,
                'created_at' => $order->created_at,
                'updated_at' => $order->update_at, 
            ];

            array_push($set_list,$set_row);
        }

        Transaction::create($set_transaction);
        ListTransaction::insert($set_list);
    }

    private static function order_store($set_data){
        $admin = User::firstWhere("is_admin",1);
        $origin = $admin->region->province_name. ",".$admin->region->city_name;
        $destination = auth()->user()->region->province_name . ",". auth()->user()->region->city_name;

        
        $set_random = Str::random(7);
        $code = Str::of("ODR-".auth()->user()->id_user."-".$set_random)->upper();


        $set_order = [
                'code' => $code,
                'user_id' => auth()->user()->id_user, 
                'order_total' => $set_data['order_total'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $set_list_order = [
                'order_code' => $code,
                'item_id' => $set_data['item_id'],
                'order_count' => $set_data['order_count'],
                'order_price' => $set_data['order_price'],
                'order_sub_total' => $set_data['order_sub_total']
            ];

            $set_expedition = [
                'order_code' => $code,
                'expedition_type' => $set_data['expedition_type'],
                'expedition_service' => $set_data['expedition_service'],
                'estimation' => $set_data['estimation'],
                'weight' => $set_data['weight'],
                'cost' => $set_data['cost'],
                'origin' => $origin,
                'destination' => $destination
            ];

            $set_payment = [
                'order_code' => $code
            ];


            Order::create($set_order);
            ListOrder::create($set_list_order);
            Expedition::create($set_expedition);
            ProofPayment::create($set_payment);

            // $item = Item::firstWhere("id_item",$set_data['item_id']);
            // Item::where("id_item",$set_data['item_id'])
            //     ->update(['item_stock' => $item['item_stock'] - $set_data['order_count']]);

            return $code;
    }

    private static function set_all_order($set_data){
        $admin = User::firstWhere("is_admin",1);
        $origin = $admin->region->province_name. ",".$admin->region->city_name;
        $destination = auth()->user()->region->province_name . ",". auth()->user()->region->city_name;

        $set_random = Str::random(7);
        $code = Str::of("ODR-".auth()->user()->id_user."-".$set_random)->upper();

        $set_order = [
            'code' => $code,
            'user_id' => auth()->user()->id_user,
            'order_total' => $set_data['order_total']
        ];
        Order::create($set_order);

        $set_expedition = [
                'order_code' => $code,
                'expedition_type' => $set_data['expedition_type'],
                'expedition_service' => $set_data['expedition_service'],
                'estimation' => $set_data['estimation'],
                'weight' => $set_data['weight'],
                'cost' => $set_data['cost'],
                'origin' => $origin,
                'destination' => $destination
            ];

        Expedition::create($set_expedition);

        $set_payment = [
                'order_code' => $code
            ];
        ProofPayment::create($set_payment);

        $set_list_order = [];
        $carts = Cart::where("user_id",auth()->user()->id_user)->get();
        foreach ($carts as $cart) {
            $list = [
                'order_code' => $code,
                'item_id' => $cart->item_id,
                'order_count' => $cart->cart_count,
                'order_price' => $cart->item->item_price,
                'order_sub_total' => $cart->cart_count * $cart->item->item_price,
                // 'created_at' => date("Y-m-d H:i:s"),
                // 'updated_at' => date("Y-m-d H:i:s")
                
            ];
             ListOrder::create($list);

        //    $item =  Item::firstWhere("id_item",$cart->item_id);
        //    Item::where("id_item",$cart->item_id)
        //     ->update([
        //         'item_stock' => $item->item_stock - $cart->cart_count
        //     ]);
        }
       

        Cart::where("user_id",auth()->user()->id_user)->delete();

        return $code;
    } 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        
         $data = [
            'title' => "Order",
            'orders' => Order::filter(request(['status']))->where("user_id",auth()->user()->id_user)->whereBetween("status_id",[1,3])->get()
        ];
        return view('pages/user/order/index',$data);
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
        $item = Item::firstWhere("id_item",$request->item_id);
        $validator = Validator::make($request->all(),[
            'item_id' => "required|numeric|min:1",
            'order_count' => "required|numeric|min:1|max:".$item->item_stock,
            'order_price' => "required|numeric|min:1",
            'order_sub_total' => "required|numeric|min:1",
            'order_total' => "required|numeric|min:1",
            'expedition_type' => "required",
            'expedition_service' => "required",
            'estimation' => "required",
            'weight' => "required|numeric|min:1",
            'cost' => "required|numeric|min:1",
            'origin' => "required|numeric|min:1",
            'destination' => "required|numeric|min:1"
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your input may be wrong or your data is incomplete, please check your personal data or the order form"
            ];
        }
        else{
            
            $set_data = $validator->validate();

            $processed = static::order_store($set_data);
            
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "you have successfully placed an order, please check your order in the order menu",
                'code' => $processed
                
            ];
        }

        return response()->json($send_json,$status_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {   
        if($order->status_id == 4 || $order->status_id == 5){
            return redirect("user/transactions/".$order->code);
        }

        $data = [
            'title' => "Order Detail",
            'order' => $order
        ];
        return view('pages/user/order/detail',$data);
        // return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function upload (Order $order,Request $request) {
        $validator = Validator::make($request->all(),[
            'order_image' => "required|image|file|max:1024"
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages(),
                "message" => "Your proof of payment upload failed"
            ];

        }

        else{

            $set_data = $validator->validate();
            $set_data['payment_image'] ="storage/".$request->file("order_image")->store("order-images");
            if($order->proof_payment->payment_image){
                Storage::delete(Str::after($order->proof_payment->payment_image,"storage/"));

            }
            ProofPayment::where("order_code",$order->code)
                            ->update(["payment_image" =>  $set_data['payment_image'],'is_valid' => 3]);


            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "you have successfully uploaded proof of payment, now the admin or seller will check your proof of payment whether it is valid or not",  
            ];
        }

        return response()->json($send_json,$status_code);
    }

      


    public function store_all(Request $request){
         $validator = Validator::make($request->all(),[
            'order_total' => "required|numeric|min:1",
            'expedition_type' => "required",
            'expedition_service' => "required",
            'estimation' => "required",
            'weight' => "required|numeric|min:1",
            'cost' => "required|numeric|min:1",
            
        ]);

        if($validator->fails()){
            


            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your order failed, check your order form again"
            ];
        }
        else{
            $set_data = $validator->validate();
            $code = static::set_all_order($set_data);
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "Your order has been successfully made",
                'code' => $code 
            ];
        }

        return response()->json($send_json,$status_code);
    }

    public function order_cancel(Order $order){

        if($order->status_id == 2){

            Order::where("code",$order->code)->update(['status_id' => 5]);
    
            $new_order = Order::firstWhere("code",$order->code);
    
            $this->addToTransaction($new_order);
            $send_json = [
                'success' => true,
                'response' => "this Order has been cancelled", 
            ];
        }
        else{
            $send_json = [
                'success' => true,
                'response' => "You has been Payment", 
        ];
        }

        
        return response()->json($send_json,200);
    }


    
}
