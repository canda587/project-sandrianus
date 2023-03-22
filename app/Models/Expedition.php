<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;
    protected $guarded = ['id_expedition'];
    protected $primaryKey = 'id_expedition';
    protected $keyType = 'string';
  

    public function order(){
        return $this->belongsTo(Order::class,"order_code");
    }

}
