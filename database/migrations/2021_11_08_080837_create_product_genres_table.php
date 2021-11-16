<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGenresTable extends Migration
{
    public function up()
    {
        Schema::create('product_genres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->nullable()->references('id')->on('products');
            $table->foreignId('movie_genre_id')->nullable()->references('id')->on('movie_genres');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_genres');
    }
}
