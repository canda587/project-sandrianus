@php
    $style_badge = "text-bg-secondary";
    if($order->status_id == 2){
        $style_badge = "text-bg-warning";    
    }
    elseif($order->status_id == 3){
         $style_badge = "text-bg-info";  
    }
    elseif($order->status_id == 4){
         $style_badge = "text-bg-success";  
    }
    elseif($order->status_id == 5){
         $style_badge = "text-bg-danger";  
    }
@endphp
<div class="p-3" style="background-color: white;">
    <div class="row">
                            <div class="col-12">
                                <div style="font-size: 1.3em;">Rincian Order</div>
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
                                        : {{ $order->user->name }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Email
                                    </div>
                                    <div class="col-8">
                                        : {{ $order->user->email }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        No Telpon
                                    </div>
                                    <div class="col-8">
                                        : {{ $order->user->phone_number }}
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
                                        {{ $order->expedition->destination }}
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
                                        : {{ $order->code }}
                                    </div>
                                </div>
                                <div class="row mb-2" >
                                    <div class="col-4 fw-bold">
                                        Status Order
                                    </div>
                                    <div class="col-8">
                                        : <span class="badge {{ $style_badge }}"> {{ $order->status_order->status_name }}</span>

                                    </div>
                                </div>
                                <div class="row mb-2" >
                                    <div class="col-4 fw-bold">
                                        Tanggal Order
                                    </div>
                                    <div class="col-8">
                                        : {{ $order->created_at }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Jenis Ekspedisi
                                    </div>
                                    <div class="col-8">
                                        : {{ $order->expedition->expedition_type }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Layanan Ekspedisi
                                    </div>
                                    <div class="col-8">
                                        : {{ $order->expedition->expedition_service }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 fw-bold">
                                        Total berat
                                    </div>
                                    <div class="col-8">
                                        : {{ ($order->expedition->weight >= 100) ? ($order->expedition->weight/1000). " Kg" : $order->expedition->weight." Gr"  }}
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
                                                : Rp. {{ number_format($order->expedition->cost,0,',','.') }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">
                                                Biaya Produk
                                            </div>
                                            <div class="col-8">
                                                : Rp. {{ number_format($order->list_order->sum("order_sub_total"),0,',','.') }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">
                                                Total harga
                                            </div>
                                            <div class="col-8">
                                                :  Rp. {{ number_format($order->order_total,0,',','.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>