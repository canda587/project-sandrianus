<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id_list_transaction'];
    protected $primaryKey = "id_list_transaction";

    public function item(){
        return $this->belongsTo(Item::class,"item_id");
    }
}
