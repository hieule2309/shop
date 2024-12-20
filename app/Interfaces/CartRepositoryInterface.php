<?php

namespace App\Interfaces;

interface CartRepositoryInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByUserId($userId); // Thêm phương thức để lấy giỏ hàng theo user
    public function deleteByUserId($userId);
}