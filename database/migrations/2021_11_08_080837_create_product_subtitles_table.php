<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubtitlesTable extends Migration
{
    public function up()
    {
        Schema::create('product_subtitles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id')->unsigned();
            $table->integer('file_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_subtitles');
    }
}
