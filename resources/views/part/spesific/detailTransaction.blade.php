@php
    $style_badge = "text-bg-secondary";
    if($transaction->status_id == 2){
        $style_badge = "text-bg-warning";    
    }
    elseif($transaction->status_id == 3){
         $style_badge = "text-bg-info";  
    }
    elseif($transaction->status_id == 4){
         $style_badge = "text-bg-success";  
    }
    elseif($transaction->status_id == 5){
         $style_badge = "text-bg-danger";  
    }
@endphp
<div class="p-3" style="background-color: white;">
    <div class="row">
                            <div class="col-12">
                                <div style="font-size: 1.3em;">Transaction Detail</div>
                               <hr class="m-0 mt-1 mb-1">
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Nama
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->user->name }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Email
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->user->email }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        No Telpon
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->user->phone_number }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Alamat
                                    </div>
                                    <div class="col-8">
                                        : 
                                    </div>
                                    <div class="col-12">
                                        {{ $transaction->expedition->destination }}
                                    </div>
                                </div>
                            </div>

                            <div class="mobile col-12">
                                <hr class="m-0 mt-1 mb-1">
                            </div>

                            <div class="col-lg-6">
                                <div class="row mb-2" >
                                    <div class="col-4 fw-bold">
                                        Faktur Order
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->code }}
                                    </div>
                                </div>
                                <div class="row mb-2" >
                                    <div class="col-4 fw-bold">
                                        Status Order
                                    </div>
                                    <div class="col-8">
                                        : <span class="badge {{ $style_badge }}"> {{ $transaction->status_order->status_name }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2" >
                                    <div class="col-4 fw-bold">
                                        Tanggal Order
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->created_at }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Jenis Ekspedisi
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->expedition->expedition_type }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Layanan Ekspedisi
                                    </div>
                                    <div class="col-8">
                                        : {{ $transaction->expedition->expedition_service }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Total berat
                                    </div>
                                    <div class="col-8">
                                        : {{ ($transaction->expedition->weight >= 100) ? ($transaction->expedition->weight/1000). " Kg" : $transaction->expedition->weight." Gr"  }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="m-0 mt-1 mb-1">
                                <div class="row">
                                    <div class="offset-lg-6 col-lg-6">
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">
                                                Biaya Kirim
                                            </div>
                                            <div class="col-8">
                                                : Rp. {{ number_format($transaction->expedition->cost,0,',','.') }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">
                                                Biaya Produk
                                            </div>
                                            <div class="col-8">
                                                : Rp. {{ number_format($transaction->list_transaction->sum("transaction_sub_total"),0,',','.') }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">
                                                Total harga
                                            </div>
                                            <div class="col-8">
                                                :  Rp. {{ number_format($transaction->transaction_total,0,',','.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>