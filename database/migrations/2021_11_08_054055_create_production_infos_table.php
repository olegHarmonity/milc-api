<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionInfosTable extends Migration
{
    public function up()
    {
        Schema::create('production_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->nullable()->references('id')->on('products');
            
            $table->date('release_year')->nullable();
            $table->date('production_year')->nullable();
            $table->string('production_status')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->text('awards')->nullable();
            $table->text('festivals')->nullable();
            $table->text('box_office')->nullable();
        });
        
        Schema::table('products', function(Blueprint $table) {
            $table->foreignId('production_info_id')->nullable()->constrained('production_infos')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_infos');
    }
}
