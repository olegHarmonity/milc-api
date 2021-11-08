<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsInformationAvailableRightsTable extends Migration
{
    public function up()
    {
        Schema::create('rights_information_available_rights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('rights_information_id')->unsigned();
            $table->integer('movie_right_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rights_information_available_rights');
    }
}
