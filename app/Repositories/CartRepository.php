<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;

class CartRepository implements CartRepositoryInterface {
    public function all() {
        return Cart::all();
    }

    public function find($id) {
        return Cart::find($id);
    }

    public function create(array $data) {
        return Cart::create($data);
    }

    public function update($id, array $data) {
        $cart = $this->find($id);
        $cart->update($data);
        return $cart;
    }

    public function delete($id) {
        $cart = $this->find($id);
        return $cart->delete();
    }

    public function getByUserId($userId) {
        return Cart::where('user_id', $userId)->get();
    }
    
    public function deleteByUserId($userId)
    {
        $cart = Cart::where('user_id', $userId);
        return $cart->delete();
    }
}