<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class UploadImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $product;
    protected $productRepository;
    protected $manager;

    public function __construct($path, $product) {
        $this->path = $path;
        $this->product = $product;
        $this->manager = new ImageManager(new Driver()); // Khởi tạo ImageManager
    }

    public function handle() {
        try {
            Log::info('Starting process image for product: ' . $this->product->id);
            // Đọc file từ storage tạm
            $file = new \Illuminate\Http\UploadedFile(
                storage_path('app/private/images/temp/' . $this->path),
                $this->path
            );

            // Upload và xử lý ảnh
            $fileName = $this->path;
            $fullPath =  'products/' . $fileName;
            
            // Tạo và xử lý ảnh với version 3
            $img = $this->manager->read($file);
            $img->scale(width: 800);
            
            // Lưu ảnh đã optimize
            Storage::disk('public')->put($fullPath, $img->encode());

            // Xóa file tạm
            Storage::disk('local')->delete('images/temp/' . $this->path);

            Log::info('Image processed successfully');
        } catch (\Exception $e) {
            Log::error('Image processing failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
