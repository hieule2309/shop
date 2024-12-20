<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động tăng
            $table->string('name'); // Tên của option
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại đến bảng products
            $table->integer('quantity'); // Số lượng
            $table->decimal('price', 10, 2); // Giá
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('options');
    }
}
