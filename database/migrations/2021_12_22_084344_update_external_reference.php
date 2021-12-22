<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExternalReference extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('external_reference')->nullable();
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->string('external_reference')->nullable();
        });
            
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('external_reference');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('external_reference');
        });
    }
}
