<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {
    public function all() {
        return Product::paginate(5);
    }

    public function find($id) {
        return Product::find($id);
    }

    public function create(array $data) {
        return Product::create($data);
    }

    public function update($id, array $data) {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id) {
        $product = $this->find($id);
        $image_path = public_path('products/' . $product->image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        return $product->delete();
    }

    public function search($search) {
        return Product::where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('category', 'LIKE', '%' . $search . '%')
            ->paginate(6);
    }
} 