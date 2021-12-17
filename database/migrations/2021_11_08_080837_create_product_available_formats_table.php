<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAvailableFormatsTable extends Migration
{
    public function up()
    {
        Schema::create('product_available_formats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('movie_format_id')->nullable()->references('id')->on('movie_formats');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_available_formats');
    }
}
