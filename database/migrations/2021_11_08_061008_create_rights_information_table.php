<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsInformationTable extends Migration
{
    public function up()
    {
        Schema::create('rights_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id')->unsigned()->nullable();
            $table->date('available_from_date');
            $table->date('expiry_date');
            $table->text('holdbacks')->nullable();
            $table->text('territories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rights_information');
    }
}
