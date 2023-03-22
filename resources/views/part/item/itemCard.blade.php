<div class="row item-content">
            
            @foreach ($item_data as $row)
              @php
                $path = "/detail/".$row['slug'];
                  if(auth()->check() && auth()->user()->is_admin){
                    $path = "/admin/items/".$row['slug']."/edit";
                  }
                  
              @endphp  
            <div class="{{ $mobile_column }} {{ $web_column }} mb-3">
                <a href="{{ $path }}" class="min-text text-decoration-none">
                    <div class="card" style="width: 100%;">
                    <img src="{{ asset($row['item_image']) }}" alt="" style="width: 100% ;height:8rem;  object-fit: cover; object-position: 15% 10%;">
                    <div class="card-body">
                        <h6 class="card-title fw-bold" style="min-height: 4rem;">{{ $row['item_name'] }}</h6>
                        <h6 class="card-title">Rp. {{ number_format($row['item_price'],0,',','.') }}</h6>
                    </div>
                    </div>        
                </a>
            </div>
            @endforeach
            
</div>