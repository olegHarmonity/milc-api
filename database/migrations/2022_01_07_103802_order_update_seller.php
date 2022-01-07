<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderUpdateSeller extends Migration
{

    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->foreignId('seller_id')
                ->nullable()
                ->unsigned()
                ->references('id')
                ->on('organisations')
                ->onDelete('set null')
                ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });
    }
}
