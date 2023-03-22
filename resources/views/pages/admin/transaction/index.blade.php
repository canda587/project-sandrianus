@extends('mainPart.mainChildBody')

@section('childContent')    
<div class="row" id="pageMyAccount" style="min-height: 25rem">
    <div class="col-12">
        <div class="row mb-2">
            <div class="col-lg-6 mb-3">
                <form action="/admin/transactions" method="get">
                    <div class="input-group mb-3 my-auto">
                        <input type="text" class="form-control" name="search" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn third-btn" type="submit" id="button-addon2" style="width: fit-content"><i class="fa-solid fa-magnifying-glass me-2"></i> Search</button>
                    </div>
                
                </form>
                

            </div>
            <div class="col-lg-6 text-end">
                <div class="dropdown">
                    <button class="btn bg-transparent dropdown-toggle" style="width: fit-content" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select a Transactions Type
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/transactions">All Transactions</a></li>
                        @foreach ($status as $st)
                            
                        <li><a class="dropdown-item" href="/admin/transactions?status={{ $st->slug }}">{{ $st->status_name }}</a></li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr class="table-warning">
                
                <th scope="col" class="text-center">Date</th>
                <th scope="col" class="text-center">Code</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Count</th>
                <th scope="col" class="text-center">Total</th>
                <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

                @if ($transactions->count() > 0)
                    @foreach ($transactions as $transaction)
                    @php
                        $style_badge = "text-bg-danger";
                        if($transaction->status_id == 4){
                            $style_badge = "text-bg-success";
                        }
                        
                    @endphp
                    <tr>
                            <td class="text-center">{{ $transaction->created_at }}</td>
                            <td class="text-center">{{ $transaction->code }}</td>
                            <td class="text-center">
                                <span class="badge {{ $style_badge }}">
                                    {{ $transaction->status_order->status_name }}
                                </span>
                            </td>
                            <td class="text-center">{{ $transaction->list_transaction->count() }}</td>
                            <td class="text-end">Rp. {{ number_format($transaction->transaction_total,0,',','.') }}</td>
                            <td class="text-center">
                                <a href="/admin/transactions/{{ $transaction->code }}" class="btn main-btn" style="width: fit-content">
                                    detail
                                </a>
                            </td>
                        </tr> 
                    @endforeach
                @else

                        <tr>
                            <td  colspan="6">
                                <div class="my-5">
                                    @include('part.item.dataNotFound')   
                                </div>
                            </td>
                        </tr>
                @endif
                
                
                
            </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center d-lg-block mt-3 mt-lg-0">
            
                {{ $transactions->links() }}
            
        </div>
        
    
    
    </div>        

</div>
@endsection