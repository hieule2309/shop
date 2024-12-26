<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories() {
        return $this->categoryRepository->all(); // Lấy tất cả các category
    }

    public function createCategory($categoryName) {
        return $this->categoryRepository->create(['category_name' => $categoryName]); // Tạo category mới
    }

    public function deleteCategory($id) {
        return $this->categoryRepository->delete($id); // Xóa category theo ID
    }

    public function findCategory($id) {
        return $this->categoryRepository->find($id); // Tìm category theo ID
    }

    public function updateCategory($id, $categoryName) {
        return $this->categoryRepository->update($id, ['category_name' => $categoryName]); // Cập nhật category
    }
}