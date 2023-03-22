<?php

namespace App\Http\Controllers\user;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Expedition;
use App\Models\ListOrder;
use App\Models\ProofPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class TransactionController extends Controller
{
    
    public function index(){

        $data = [
            'title' => 'Transaction',
            'orders' => Order::filter(request(['status']))->where("user_id",auth()->user()->id_user)->whereBetween("status_id",[4,5])->get()
        ];

        return view('pages/user/transaction/index',$data);

    }


    public function show(Order $order){
        $data = [
            'title' => "Transaction Detail",
            'order' => $order
        ];
        return view('pages/user/transaction/detail',$data);
    }

    public function destroy(Order $order){
        $transaction = Transaction::firstWhere("code",$order->code);
        if(!$transaction){
            Expedition::where("order_code",$order->code)->delete();
            ProofPayment::where("order_code",$order->code)->delete();
            Storage::delete(Str::after($order->proof_payment->payment_image,"storage/"));
        }
        
        ListOrder::where("order_code",$order->code)->delete();
        Order::where("code",$order->code)->delete();

        $send_json = [
            'success' => true,
            'response' => "This transaction data has been successfully deleted"
        ];

        return response()->json($send_json,200);
    }
}
