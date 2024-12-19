<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $orderRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, OrderRepositoryInterface $orderRepository) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
    }

    public function view_category() {
        $data = $this->categoryRepository->all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request) {
        $this->categoryRepository->create(['category_name' => $request->category]);
        flash()->success('Category added successfully');
        return redirect()->back();
    }

    public function delete_category($id) {
        $this->categoryRepository->delete($id);
        flash()->success('Category deleted successfully');
        return redirect()->back();
    }

    public function edit_category($id) {
        $data = $this->categoryRepository->find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id) {
        $this->categoryRepository->update($id, ['category_name' => $request->category]);
        flash()->success('Category updated successfully');
        return redirect('/view_category');
    }

    public function add_product() {
        $category = $this->categoryRepository->all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request) {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data['image'] = $imagename;
        }
        $this->productRepository->create($data);
        flash()->success('Product added successfully');
        return redirect('/view_product');
    }

    public function view_product() {
        $product = $this->productRepository->all();
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id) {
        $this->productRepository->delete($id);
        flash()->success('Product deleted successfully');
        return redirect()->back();
    }

    public function update_product($id) {
        $data = $this->productRepository->find($id);
        $category = $this->categoryRepository->all()->where('category_name', '<>', $data->category);
        return view('admin.update_product', compact('data', 'category'));
    }

    public function edit_product(Request $request, $id) {
        $data = $this->productRepository->update($id, $request->all());
        flash()->success('Product updated successfully');
        return redirect('/view_product');
    }

    public function product_search(Request $request) {
        $search = $request->search;
        $product = $this->productRepository->search($search);
        return view('admin.view_product', compact('product'));
    }

    public function view_order() {
        $data = $this->orderRepository->all();
        return view('admin.view_order', compact('data'));
    }
}
