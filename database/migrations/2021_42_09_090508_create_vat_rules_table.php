<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatRulesTable extends Migration
{
    public function up()
    {
        Schema::create('vat_rules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('vat_id')->nullable()->references('id')->on('percentages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('organisation_id')->nullable()->references('id')->on('organisations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('rule_type');
            $table->string('country')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vat_rules');
    }
}
