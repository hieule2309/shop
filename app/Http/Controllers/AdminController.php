<?php

namespace App\Http\Controllers;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function view_category(){
        $data = Category::all();
        return view('admin.category', compact('data'));
    }
    public function add_category(Request $request){
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();
        flash()->success('Category added successfully');
        return redirect()->back();
    }
    public function delete_category($id){
        $data = Category::find($id);
        $data->delete();
        flash()->success('Category deleted successfully');
        return redirect()->back();
    }
    public function edit_category($id){
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }
    public function update_category(Request $request, $id){
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();
        flash()->success('Category updated successfully');
        return redirect('/view_category');
    }
    public function add_product(){
        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }
    public function upload_product(Request $request){
        $data = new Product();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->category = $request->category;
        $data->quantity = $request->qty;
        $image = $request->image;
        if($image){
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }
        $data->save();
        flash()->success('Product added successfully');
        return redirect('/view_product');
    }
    public function view_product(){
        $product = Product::paginate(5);
        return view('admin.view_product', compact('product'));
    }
    public function delete_product($id){
        $data = Product::find($id);
        $image_path = public_path('products/' . $data->image);
        if(file_exists($image_path)){
            unlink($image_path);
        }
        $data->delete();
        flash()->success('Product deleted successfully');
        return redirect()->back();
    }
    public function update_product($id){
        $data = Product::find($id);
        $category = Category::where('category_name','<>',$data->category)->get();
        return view('admin.update_product', compact('data','category'));
    }
    public function edit_product(Request $request, $id){
        $data = Product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $data->price = $request->price;
        $image = $request->image;
        if($image){
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
            $data->image = $imagename;
        }
        $data->save();
        flash()->success('Product updated successfully');
        return redirect('/view_product');
    }
    public function product_search(Request $request){
        $search = $request->search;
        $product = Product::where('title','LIKE','%' . $search . '%')
        ->orWhere('category','LIKE','%' . $search . '%')
        ->paginate(6);
        return view('admin.view_product', compact('product'));
    }
    public function view_order(){
        $data = Order::all();
        return view('admin.view_order',compact('data'));
    }
}
