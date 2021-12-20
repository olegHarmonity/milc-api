<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganisationDesc extends Migration
{

    public function up()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->text('description')->change();
        });
    }

    public function down()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
}
