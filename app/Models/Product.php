<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'category',
        'quantity'
    ];

    public function option(){
        return $this->hasMany(Option::class);
    }

    public function optionAttribute(){
        return $this->hasMany(OptionAttribute::class);
    }
}
