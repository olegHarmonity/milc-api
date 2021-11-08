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
            $table->integer('product_id')->unsigned();
            $table->integer('movie_format_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_available_formats');
    }
}
