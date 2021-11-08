<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionInfoWritersTable extends Migration
{
    public function up()
    {
        Schema::create('production_info_writers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('production_info_id')->unsigned();
            $table->integer('person_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_info_writers');
    }
}
