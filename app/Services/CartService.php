<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addProductToCart($productId)
    {
        $user = Auth::user();
        if ($user) {
            $data = [
                'user_id' => $user->id,
                'product_id' => $productId,
            ];
            return $this->cartRepository->create($data);
        }
        return null; // Hoặc xử lý lỗi nếu người dùng không đăng nhập
    }

    public function removeProductFromCart($productId)
    {
        $user = Auth::user();
        if ($user) {
            return $this->cartRepository->delete($productId);
        }
        return null; // Hoặc xử lý lỗi nếu người dùng không đăng nhập
    }

    public function getCartByUserId($userId)
    {
        return $this->cartRepository->getByUserId($userId);
    }

    public function getCartCount()
    {
        $user = Auth::user();
        if ($user) {
            return $this->cartRepository->getByUserId($user->id)->count();
        }
        return 0; // Nếu người dùng không đăng nhập
    }

    public function clearCart()
    {
        $user = Auth::user();
        if ($user) {
            return $this->cartRepository->deleteByUserId($user->id);
        }
        return null; // Hoặc xử lý lỗi nếu người dùng không đăng nhập
    }
}