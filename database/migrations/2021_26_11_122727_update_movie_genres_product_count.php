<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMovieGenresProductCount extends Migration
{
 
    public function up()
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->integer('product_count')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->dropColumn('product_count');
        });
    }
}
