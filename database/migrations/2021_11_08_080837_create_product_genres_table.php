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
            $table->integer('product_id')->unsigned();
            $table->integer('movie_genre_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_genres');
    }
}
