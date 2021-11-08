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
            $table->integer('marketing_assets_id')->unsigned();
            $table->integer('image_id')->unsigned();
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
