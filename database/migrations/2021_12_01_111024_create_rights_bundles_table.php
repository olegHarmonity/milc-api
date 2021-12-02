<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsBundlesTable extends Migration
{
    public function up()
    {
        Schema::create('rights_bundles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('price_id')->unsigned()->references('id')->on('money')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rights_bundles');
    }
}
