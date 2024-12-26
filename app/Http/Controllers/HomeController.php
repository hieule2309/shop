<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $productService;
    protected $cartService;
    protected $orderService;

    public function __construct(ProductService $productService, CartService $cartService, OrderService $orderService) {
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(){
        return view('admin.index');
    }

    public function home(){
        $product = $this->productService->getAllProducts();
        $count = $this->cartService->getCartCount(Auth::id());
        return view('home.index', compact('product', 'count'));
    }

    public function product_details($id){
        $data = $this->productService->findProduct($id);
        $count = $this->cartService->getCartCount(Auth::id());
        return view('home.product_details', compact('data', 'count'));
    }

    public function add_cart($id){
        $this->cartService->addProductToCart(Auth::id(), $id);
        flash()->success('Add product to cart successfully');
        return redirect()->back();
    }

    public function mycart(){
        $count = $this->cartService->getCartCount(Auth::id());
        $cart = $this->cartService->getCartByUserId(Auth::id());
        return view('home.mycart', compact('count', 'cart'));
    }

    public function remove_product_cart($id){
        $this->cartService->removeProductFromCart($id);
        flash()->success('Remove product cart successfully');
        return redirect()->back();
    }

    public function confirm_order(Request $request){
        $data = $request->only(['name', 'address', 'phone']);
        $user_id = Auth::user()->id;
        $cart = $this->cartService->getCartByUserId($user_id);
        $this->orderService->createUserOrder($cart, $data);
        $this->cartService->clearCart();
        flash()->success('Order successfully');
        return redirect()->back();
    }
}
