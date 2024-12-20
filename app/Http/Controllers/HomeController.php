<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $productRepository;
    protected $cartRepository;
    protected $orderRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CartRepositoryInterface $cartRepository, OrderRepositoryInterface $orderRepository) {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(){
        return view('admin.index');
    }

    public function home(){
        $product = $this->productRepository->all();
        $count = 0;
        if(Auth::user()){
            $user_id = Auth::user()->id;
            $count = $this->cartRepository->getByUserId($user_id)->count();
        }
        return view('home.index', compact('product', 'count'));
    }

    public function product_details($id){
        $data = $this->productRepository->find($id);
        $count = 0;
        if(Auth::user()){
            $user_id = Auth::user()->id;
            $count = $this->cartRepository->getByUserId($user_id)->count();
        }
        return view('home.product_details', compact('data', 'count'));
    }

    public function add_cart($id){
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'product_id' => $id,
        ];
        $this->cartRepository->create($data);
        flash()->success('Add product to cart successfully');
        return redirect()->back();
    }

    public function mycart(){
        $count = 0;
        $cart = [];
        if(Auth::id()){
            $user_id = Auth::user()->id;
            $count = $this->cartRepository->getByUserId($user_id)->count();
            $cart = $this->cartRepository->getByUserId($user_id);
        }
        return view('home.mycart', compact('count', 'cart'));
    }

    public function remove_product_cart($id){
        $user_id = Auth::user()->id;
        $this->cartRepository->delete($id);
        flash()->success('Remove product cart successfully');
        return redirect()->back();
    }

    public function confirm_order(Request $request){
        $data = $request->only(['name', 'address', 'phone']);
        $user_id = Auth::user()->id;
        $cart = $this->cartRepository->getByUserId($user_id);

        foreach($cart as $carts){
            $orderData = [
                'name' => $data['name'],
                'rec_address' => $data['address'],
                'phone' => $data['phone'],
                'user_id' => $user_id,
                'product_id' => $carts->product_id,
            ];
            $this->orderRepository->create($orderData);
        }

        $this->cartRepository->deleteByUserId($user_id); 
        flash()->success('Order successfully');
        return redirect()->back();
    }
}
