<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRightsInformation extends Migration
{
    public function up()
    {
        Schema::table('rights_information', function (Blueprint $table) {
            $table->string('title');
            $table->text('short_description');
            $table->text('long_description');
        });
    }

    public function down()
    {
        Schema::table('rights_information', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('short_description');
            $table->dropColumn('long_description');
        });
    }
}
