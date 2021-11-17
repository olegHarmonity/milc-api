<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRightsInformationTable extends Migration
{
    public function up()
    {
        Schema::create('product_rights_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('rights_information_id')->nullable()->references('id')->on('rights_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rights_information');
    }
}
