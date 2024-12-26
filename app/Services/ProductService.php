<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OptionRepositoryInterface;
use App\Interfaces\OptionAttributeRepositoryInterface;
use App\Jobs\UploadImageJob;

class ProductService
{
    protected $productRepository;
    protected $categoryRepository;
    protected $optionRepository;
    protected $optionAttributeRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        OptionRepositoryInterface $optionRepository,
        OptionAttributeRepositoryInterface $optionAttributeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->optionRepository = $optionRepository;
        $this->optionAttributeRepository = $optionAttributeRepository;
    }

    public function getAllProducts() {
        return $this->productRepository->all(); // Lấy tất cả sản phẩm
    }

    public function createProduct($data) {
        $data['quantity'] = $data['qty'];
        $product = $this->productRepository->create($data); // Tạo sản phẩm

        foreach ($data['options'] as $index => $option) {
            $insert_option_item = [
                'name' => $option,
                'product_id' => $product->id,
                'quantity' => $data['options_quantity'][$index],
                'price' => $data['options_price'][$index]
            ];
            $insert_option = $this->optionRepository->create($insert_option_item);

            foreach ($data['options_image'][$index] as $image_index => $option_image) {
                $imageName = implode('_', [unicode_convert($option), $image_index, time()]) . '.' . $option_image->getClientOriginalExtension();
                $option_image->storeAs('images/temp', $imageName); // Lưu ảnh vào thư mục tạm

                $insert_option_attribute_item = [
                    'product_id' => $product->id,
                    'option_id' => $insert_option->id,
                    'item_key' => 'image',
                    'item_value' => $imageName
                ];

                if (empty($data['image']) && $image_index == 0) {
                    $data['image'] = $imageName; // Cập nhật hình ảnh mặc định
                }

                $this->optionAttributeRepository->create($insert_option_attribute_item);
                UploadImageJob::dispatch($imageName, $product); // Gửi job xử lý hình ảnh
            }
        }

        $product->update($data); // Cập nhật thông tin sản phẩm
        return $product; // Trả về sản phẩm đã tạo
    }

    public function deleteProduct($id) {
        return $this->productRepository->delete($id); // Xóa sản phẩm theo ID
    }

    public function findProduct($id) {
        return $this->productRepository->find($id); // Tìm sản phẩm theo ID
    }

    public function updateProduct($id, $data) {
        return $this->productRepository->update($id, $data); // Cập nhật sản phẩm
    }

    public function searchProduct($search) {
        return $this->productRepository->search($search); // Tìm kiếm sản phẩm
    }
}