<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{

    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('vat_percentage_id')
                ->unsigned()
                ->references('id')
                ->on('percentages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('vat_id')
                ->unsigned()
                ->references('id')
                ->on('money')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('vat_percentage_id');
            $table->dropColumn('vat_id');
        });
    }
}
