<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'address', 'stkId', 'phone', 'user_id', 'product_id', 'qty', 'price'
    ];
}
