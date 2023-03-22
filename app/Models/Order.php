<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id_order'];
    protected $primaryKey = "code";
    protected $keyType = 'string';
    protected $with = ['user','status_order','list_order','expedition','proof_payment'];

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['status'] ?? false, fn ($query,$status) =>

            $query->whereHas('status_order', fn ($query) => 
                $query->where('slug',$status)
            
            )
        
        );

        $query->when($filters['search'] ?? false, fn ($query,$search) =>

            $query->where('code','like','%'.$search.'%')

            // $query->whereHas('status_order', fn ($query) => 
            //     $query->where('slug',$status)
            
            // )
        
        );

        
    }


    public function getRouteKeyName()
    {
        return 'code';
    }

    public function user (){
        return $this->belongsTo(User::class,"user_id");
    }

    public function status_order(){
        return $this->belongsTo(StatusOrder::class,"status_id");
    }

    public function list_order(){
        return $this->HasMany(ListOrder::class,"order_code");
    }

    public function expedition(){
        return $this->HasOne(Expedition::class,"order_code");
    }

    public function proof_payment(){
        return $this->HasOne(ProofPayment::class,"order_code");
    }
}
