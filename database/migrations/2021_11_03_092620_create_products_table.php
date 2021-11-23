<?php

use App\Util\ProductStatuses;
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

            $table->foreignId('organisation_id')->unsigned()->references('id')->on('organisations');
            $table->foreignId('content_type_id')->unsigned()->nullable()->references('id')->on('movie_content_types');
            $table->foreignId('movie_id')->unsigned()->nullable()->references('id')->on('videos');
            $table->foreignId('screener_id')->unsigned()->nullable()->references('id')->on('videos');
            $table->foreignId('trailer_id')->unsigned()->nullable()->references('id')->on('videos');

            $table->string('title');
            $table->string('alternative_title')->nullable();
            $table->integer('runtime')->unsigned()->nullable();
            $table->text('synopsis')->nullable();
            $table->text('keywords')->nullable();
            $table->string('original_language')->nullable();
            $table->text('dubbing_languages')->nullable();
            $table->text('subtitle_languages')->nullable();
            $table->text('links')->nullable();
            $table->boolean('allow_requests')->default(false);
            $table->string('status')->default(ProductStatuses::$ACTIVE);
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
