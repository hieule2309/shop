<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $categoryService;
    protected $productService;
    protected $orderService;

    public function __construct(CategoryService $categoryService, ProductService $productService, OrderService $orderService) {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->orderService = $orderService;
    }

    public function view_category() {
        $data = $this->categoryService->getAllCategories();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request) {
        $this->categoryService->createCategory($request->category);
        flash()->success('Category added successfully');
        return redirect()->back();
    }

    public function delete_category($id) {
        $this->categoryService->deleteCategory($id);
        flash()->success('Category deleted successfully');
        return redirect()->back();
    }

    public function edit_category($id) {
        $data = $this->categoryService->findCategory($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id) {
        $this->categoryService->updateCategory($id, $request->category);
        flash()->success('Category updated successfully');
        return redirect('/view_category');
    }

    public function add_product() {
        $category = $this->categoryService->getAllCategories();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request) {
        $this->productService->createProduct($request);
        flash()->success('Product added successfully');
        return redirect('/view_product');
    }

    public function view_product() {
        $product = $this->productService->getAllProducts();
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id) {
        $this->productService->deleteProduct($id);
        flash()->success('Product deleted successfully');
        return redirect()->back();
    }

    public function update_product($id) {
        $data = $this->productService->findProduct($id);
        $category = $this->categoryService->getAllCategories()->where('category_name', '<>', $data->category);
        return view('admin.update_product', compact('data', 'category'));
    }

    public function edit_product(Request $request, $id) {
        $this->productService->updateProduct($id, $request->all());
        flash()->success('Product updated successfully');
        return redirect('/view_product');
    }

    public function product_search(Request $request) {
        $search = $request->search;
        $product = $this->productService->searchProduct($search);
        return view('admin.view_product', compact('product'));
    }

    public function view_order() {
        $data = $this->orderService->getAllOrders();
        return view('admin.view_order', compact('data'));
    }
}
