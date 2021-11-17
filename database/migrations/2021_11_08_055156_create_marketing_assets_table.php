<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('marketing_assets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->unsigned()->nullable()->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('key_artwork_id')->unsigned()->nullable()->references('id')->on('images');
            
            $table->text('copyright_information');
            $table->text('links')->nullable();
        });
            
        Schema::table('products', function(Blueprint $table) {
            $table->foreignId('marketing_assets_id')->unsigned()->nullable()->references('id')->on('marketing_assets')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_assets');
    }
}
