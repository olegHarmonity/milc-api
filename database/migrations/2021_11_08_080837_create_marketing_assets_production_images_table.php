<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingAssetsProductionImagesTable extends Migration
{
    public function up()
    {
        Schema::create('marketing_assets_production_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('marketing_assets_id')->unsigned()->nullable()->references('id')->on('marketing_assets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('image_id')->unsigned()->unsigned()->nullable()->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_assets_production_images');
    }
}
