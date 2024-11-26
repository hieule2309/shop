<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function home(){
        $product = Product::all();
        $count = 0;
        if(Auth::user()){
            $user_id = Auth::user()->id;
            $count = Cart::where('user_id', $user_id)->count();
        }
        return view('home.index', compact('product','count'));
    }
    public function product_details($id){
        $data = Product::find($id);
        $count = 0;
        if(Auth::user()){
            $user_id = Auth::user()->id;
            $count = Cart::where('user_id', $user_id)->count();
        }
        return view('home.product_details',compact('data','count'));
    }
    public function add_cart($id){
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();
        flash()->success('Add product to cart successfully');
        return redirect()->back();
    }
    public function mycart(){
        if(Auth::id()){
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
            $cart = Cart::where('user_id',$user_id)->get();
        }
        return view('home.mycart',compact('count','cart'));
    }
    public function remove_product_cart($id){
        $user = Auth::user();
        $user_id = $user->id;
        $data = Cart::where('id', $id)->where('user_id',$user_id)->first();
        $data->delete();
        flash()->success('Remove product cart successfully');
        return redirect()->back();
    }
    public function confirm_order(Request $request){
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id',$user_id)->get();
        foreach($cart as $carts){
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $user_id;
            $order->product_id = $carts->product_id;
            $order->save();
        }
        $cart_remove = Cart::where('user_id', $user_id)->delete();
        flash()->success('Order successfully');
        return redirect()->back();
    }
}
