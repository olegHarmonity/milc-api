<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganisation extends Migration
{

    public function up()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('iban')->nullable();
            $table->string('swift_bic')->nullable();
            $table->string('bank_name')->nullable();
        });
    }

   
    public function down()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('iban');
            $table->dropColumn('swift_bic');
            $table->dropColumn('bank_name');
        });
    }
}
