<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderFkyRightsBundle extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('rights_bundle_id')->change()->nullable()->unsigned();
            $table->foreignId('rights_bundle_id')->change()->nullOnDelete();
        });
    }

    public function down()
    {

    }
}
