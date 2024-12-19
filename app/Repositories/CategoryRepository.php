<?php

namespace App\Repositories;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {
    public function all() {
        return Category::all();
    }

    public function find($id) {
        return Category::find($id);
    }

    public function create(array $data) {
        return Category::create($data);
    }

    public function update($id, array $data) {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id) {
        $category = $this->find($id);
        return $category->delete();
    }
} 