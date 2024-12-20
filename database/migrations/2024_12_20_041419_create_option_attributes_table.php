<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('option_attributes', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động tăng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại đến bảng products
            $table->foreignId('option_id')->constrained()->onDelete('cascade'); // Khóa ngoại đến bảng options
            $table->string('item_key'); // Khóa của thuộc tính
            $table->string('item_value'); // Giá trị của thuộc tính
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('option_attributes');
    }
}
