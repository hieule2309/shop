<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\OptionRepositoryInterface;
use App\Interfaces\OptionAttributeRepositoryInterface;
use Illuminate\Http\Request;
use App\Jobs\UploadImageJob;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $orderRepository;
    protected $optionRepository;
    protected $optionAttributeRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, OrderRepositoryInterface $orderRepository, OptionRepositoryInterface $optionRepository, OptionAttributeRepositoryInterface $optionAttributeRepository) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
        $this->optionRepository = $optionRepository;
        $this->optionAttributeRepository = $optionAttributeRepository;
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
        $data['quantity'] = $data['qty'];
        // Thực hiện tạo sản phẩm
        $product = $this->productRepository->create($data);
        foreach($data['options'] as $index => $option){
            // Bắt đầu thêm dữ liệu lựa chọn của sản phẩm
            $insert_option_item = [
                'name'          => $option,
                'product_id'    => $product->id,
                'quantity'      => $data['options_quantity'][$index],
                'price'         => $data['options_price'][$index]
            ];
            $insert_option = $this->optionRepository->create($insert_option_item);
            foreach($request->options_image[$index] as $image_index => $option_image){
                $imageName = implode('_',[unicode_convert($option), $image_index, time()]) . '.' . $option_image->getClientOriginalExtension();
                // Tiến hành lưu ảnh vào thư mục tạm để sẽ xử lý hàng đợi hình ảnh sau 
                $option_image->storeAs('images/temp', $imageName);
                // Lưu hình ảnh vào cơ sở dữ liệu
                $insert_option_attribute_item = [
                    'product_id'    => $product->id,
                    'option_id'     => $insert_option->id,
                    'item_key'      => 'image',
                    'item_value'    => $imageName
                ];
                # Cập nhật hình ảnh đầu tiên của lựa chọn đầu tiên là hình ảnh mặc định của sản phẩm
                if(empty($data['image']) && $image_index == 0){
                    $data['image'] = $imageName;
                }
                $this->optionAttributeRepository->create($insert_option_attribute_item);
                // Tiến hành xử lý hàng đợi cho hình ảnh
                UploadImageJob::dispatch($imageName, $product);
            }
        }
        $product = $product->update($data);
        // Sau khi đã lưu ảnh vào folder tạm và tạo sản phẩm thành công thì tiến hành gửi job để xử lý hỉnh ảnh
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
