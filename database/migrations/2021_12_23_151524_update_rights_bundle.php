<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRightsBundle extends Migration
{
    public function up()
    {
        Schema::table('rights_bundles', function (Blueprint $table) {
            $table->foreignId('buyer_id')->unsigned()->nullable()->references('id')->on('organisations')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::table('rights_bundles', function (Blueprint $table) {
            $table->dropColumn('buyer_id');
        });
    }
}
