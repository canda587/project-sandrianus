<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $guarded = ['id_region'];

    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public function User(){
        return $this->HasOne(User::class,"region_code");
    }
}
