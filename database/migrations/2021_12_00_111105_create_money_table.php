<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTable extends Migration
{
    public function up()
    {
        Schema::create('money', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('value')->nullable();
            $table->string('currency')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('money');
    }
}
