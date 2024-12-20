<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_id', 'item_key', 'item_value']; // Các trường có thể được gán hàng loạt

    public function option()
    {
        return $this->belongsTo(Option::class); // Quan hệ nhiều-1 với Option
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
