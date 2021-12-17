<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContracts extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->longText('contract_text_part_2');
            $table->longText('contract_appendix')->nullable();
        });
    }

    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('contract_text_part_2');
            $table->dropColumn('contract_appendix');
        });
    }
}
