<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $keyType = 'string';

}
