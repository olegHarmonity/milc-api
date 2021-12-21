<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderTimestamps extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('contract_accepted')->default(false);
            $table->dateTime('contract_accepted_at')->nullable();
            $table->dateTime('payment_started_at')->nullable();
            $table->dateTime('assets_sent_at')->nullable();
            $table->dateTime('assets_received_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->dateTime('paid_at')->nullable();
        });
            
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('contract_accepted');
            $table->dropColumn('contract_accepted_at');
            $table->dropColumn('payment_started_at');
            $table->dropColumn('assets_sent_at');
            $table->dropColumn('assets_received_at');
            $table->dropColumn('completed_at');
            $table->dropColumn('rejected_at');
            $table->dropColumn('cancelled_at');
            $table->dropColumn('refunded_at');
            $table->dropColumn('paid_at');
        });
    }
}
