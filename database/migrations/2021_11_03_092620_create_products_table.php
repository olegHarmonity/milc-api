<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('organisation_id')->unsigned();
            $table->integer('production_info_id')->unsigned()->nullable();
            $table->integer('marketing_assets_id')->unsigned()->nullable();
            $table->integer('movie_id')->unsigned()->nullable();
            $table->integer('screener_id')->unsigned()->nullable();
            $table->integer('trailer_id')->unsigned()->nullable();

            $table->string('title');
            $table->string('alternative_title');
            $table->string('content_type')->nullable();
            $table->integer('runtime')->unsigned();
            $table->text('synopsis');
            $table->text('keywords');
            $table->string('original_language');
            $table->text('dubbing_languages');
            $table->text('subtitle_languages');
            $table->text('links');
            $table->boolean('allow_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
