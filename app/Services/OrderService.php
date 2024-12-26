<?php

namespace App\Services;

use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders() {
        return $this->orderRepository->all(); // Lấy tất cả đơn hàng
    }

    public function createOrder($data){
        return $this->orderRepository->create($data); // Tạo đơn hàng mới
    }

    public function createUserOrder($carts, $address) {
        $user = Auth::user();
        foreach($carts as $cart){
            $orderData = [
                'name' => $address['name'],
                'rec_address' => $address['address'],
                'phone' => $address['phone'],
                'user_id' => $user->id,
                'product_id' => $cart->product_id,
            ];
            $this->createOrder($orderData);
        }
    }

    public function deleteOrder($id) {
        return $this->orderRepository->delete($id); // Xóa đơn hàng theo ID
    }

    public function findOrder($id) {
        return $this->orderRepository->find($id); // Tìm đơn hàng theo ID
    }

    public function updateOrder($id, $data) {
        return $this->orderRepository->update($id, $data); // Cập nhật thông tin đơn hàng
    }
}