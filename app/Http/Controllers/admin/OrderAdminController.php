<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ListTransaction;
use App\Models\StatusOrder;
use App\Models\ProofPayment;
class OrderAdminController extends Controller
{

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


    public function index(){
        $data = [
            'title' => "Order Data",
            'status' => StatusOrder::whereBetween("id_status",[1,3])->get(), 
            'orders' => Order::filter(request(['status','search']))->whereBetween('status_id',[1,3])->paginate(10)->withQueryString()
        ];
        return view('pages/admin/order/index',$data);
    }

    public function show(Order $order){
        if($order->status_id == 4 || $order->status_id == 5){
            return redirect("admin/transactions/".$order->code);
        }

        $data = [
            'title' => "Order Detail",
            'order' => $order
        ];
        return view('pages/admin/order/detail',$data);
    }

    public function update_status(Order $order,Request $request){

        if(!empty($order->proof_payment->payment_image) && $order->proof_payment->is_valid == 1){
            $is_finish = false;
            Order::where("id_order",$order->id_order)
                ->update(["status_id" => $request->status]);

            if($request->is_finish == 1 ){
                $is_finish = true;
                $new_order = Order::firstWhere("id_order",$order->id_order);
                $this->addToTransaction($new_order);
            }    

            $status_code =200;
            $send_json = [
                'success' => true,
                'is_finish' => $is_finish,
                'response' => "The status of this order has been successfully updated"
            ];
        }
        else{
            $status_code =422;
            $send_json = [
                'success' => false,
                'response' => "You cannot update this order because this order has not made a payment"
            ];

        }

      

        return response()->json($send_json,$status_code);
    }

    public function set_payment(Order $order,Request $request){


        ProofPayment::where("order_code", $order->code)
                    ->update(['is_valid' => $request->is_valid]);
        
        $message = "proof of payment has been set to be invalid";
        if($request->is_valid == 1){
            $message = "proof of payment has been set to be valid and the status of this order has been updated to complete payment";
            Order::where("code", $order->code)
                    ->update(['status_id' => 2]);
        }



        $send_json = [
                'success' => true,
                'response' => $message
        ];
        return response()->json($send_json,200);
    }
}
