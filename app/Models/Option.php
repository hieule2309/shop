<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['name','product_id','quantity', 'price']; // Các trường có thể được gán hàng loạt

    public function optionAttributes()
    {
        return $this->hasMany(OptionAttribute::class); // Quan hệ 1-nhiều với OptionAttribute
    }

    public function product(){
        return $this->belongsTo(Product::class); 
    }
}
