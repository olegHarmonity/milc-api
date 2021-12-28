<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('message');
            $table->string('category');
            $table->foreignId('organisation_id')->nullable()->references('id')->on('organisations');
            $table->foreignId('sender_id')->nullable()->references('id')->on('organisations');
            $table->boolean('is_for_admin')->default(false);
            $table->boolean('is_read')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
