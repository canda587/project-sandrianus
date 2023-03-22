<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Cart extends Model
{
    use HasFactory;


    protected $guarded = ["id_cart"];
    protected $primaryKey = "id_cart";
    protected $with = ['item'];
    public function item()
    {
        return $this->belongsTo(Item::class,"item_id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
}
