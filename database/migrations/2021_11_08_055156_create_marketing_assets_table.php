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
            $table->integer('product_id')->unsigned()->nullable()->nullable();
            $table->integer('key_artwork_id')->unsigned()->nullable();
            $table->text('copyright_information');
            $table->text('links')->nullable();
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
