<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionInfoCastTable extends Migration
{
    public function up()
    {
        Schema::create('production_info_cast', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('production_info_id')->nullable()->references('id')->on('production_infos')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('person_id')->nullable()->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_info_cast');
    }
}
