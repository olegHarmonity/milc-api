<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Util\CartStates;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->foreignId('price_id')->unsigned()->references('id')->on('money')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('vat_id')->unsigned()->references('id')->on('percentages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('total_id')->unsigned()->references('id')->on('money')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('rights_bundle_id')->unsigned()->references('id')->on('rights_bundles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('organisation_id')->unsigned()->references('id')->on('organisations');
            $table->foreignId('buyer_user_id')->unsigned()->references('id')->on('users');
            
            $table->string('contact_email');
            $table->string('delivery_email');
            $table->string('organisation_name');
            $table->string('organisation_type');
            $table->string('organisation_email');
            $table->string('organisation_phone');
            $table->string('organisation_address');
            $table->string('organisation_registration_number');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_email');
            $table->string('billing_address');
            $table->string('pay_in_currency')->nullable();
            $table->float('exchange_rate')->nullable();
            
            $table->string('state')->default(CartStates::$NEW);
            $table->string('order_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
