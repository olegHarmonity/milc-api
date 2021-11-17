<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsInformationAvailableRightsTable extends Migration
{
    public function up()
    {
        Schema::create('rights_info_available_rights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('rights_information_id')->nullable()->references('id')->on('rights_information')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('movie_right_id')->nullable()->references('id')->on('movie_rights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rights_info_available_rights');
    }
}
