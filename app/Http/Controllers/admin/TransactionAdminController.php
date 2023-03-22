<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ListTransaction;
use App\Models\Order;
use App\Models\Expedition;
use App\Models\StatusOrder;
use App\Models\ProofPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class TransactionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => "Transaction Data",
            'status' => StatusOrder::whereBetween("id_status",[4,5])->get(),
            'transactions' => Transaction::filter(request(['status','search']))->paginate(10)->withQueryString()
        ];

        return view("pages/admin/transaction/index",$data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $data = [
            'title' => "Transaction Detail",
            'transaction' => $transaction
        ];

      
        return view("pages/admin/transaction/detail",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $order = Order::firstWhere("code",$transaction->code);
        if(!$order){
            Expedition::where("order_code",$transaction->code)->delete();
            ProofPayment::where("order_code",$transaction->code)->delete();
            Storage::delete(Str::after($transaction->proof_payment->payment_image,"storage/"));

        }
        
        ListTransaction::where("transaction_code",$transaction->code)->delete();
        Transaction::where("code",$transaction->code)->delete();

        $send_json = [
            'success' => true,
            'response' => "This transaction data has been successfully deleted"
        ];

        return response()->json($send_json,200);
    }
}
