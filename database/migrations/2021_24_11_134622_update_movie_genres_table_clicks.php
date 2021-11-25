<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMovieGenresTableClicks extends Migration
{

    public function up()
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->integer('number_of_clicks')->default(0);
        });
    }

    public function down()
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->dropColumn('number_of_clicks');
        });
    }
}
