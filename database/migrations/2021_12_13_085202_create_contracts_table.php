<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CreateContractsTable extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('seller_id')->nullable()->references('id')->on('organisations')->onDelete('set null');
            $table->foreignId('buyer_id')->nullable()->references('id')->on('organisations')->onDelete('set null');
            $table->foreignId('rights_bundle_id')->nullable()->references('id')->on('rights_bundles')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->references('id')->on('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('contract_text');
            $table->boolean('is_default')->default(false);
            $table->dateTime('accepted_at', 0)->nullable();
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable()->references('id')->on('contracts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
