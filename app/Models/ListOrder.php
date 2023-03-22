<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id_list_order'];
    protected $primaryKey = "id_list_order";
    protected $keyType = 'string';
    public function item(){
        return $this->belongsTo(Item::class,"item_id");
    }

    public function order(){
        return $this->belongsTo(Order::class,"order_code");
    }
}
