<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPromotionalVideosTable extends Migration
{
    public function up()
    {
        Schema::create('product_promotional_videos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id')->unsigned();
            $table->integer('video_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_promotional_videos');
    }
}
