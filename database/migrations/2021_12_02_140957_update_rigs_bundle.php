<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRigsBundle extends Migration
{

    public function up()
    {
        if (!Schema::hasColumn('rights_bundles', 'product_id')) {
            Schema::table('rights_bundles', function (Blueprint $table) {
                $table->foreignId('product_id')
                    ->nullable()
                    ->unsigned()
                    ->references('id')
                    ->on('products')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }
    }

    public function down()
    {
        Schema::table('rights_bundles', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
}