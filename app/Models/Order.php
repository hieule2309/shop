<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'product_id',
        'name',
        'rec_address',
        'phone',
        'status'
    ];
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
