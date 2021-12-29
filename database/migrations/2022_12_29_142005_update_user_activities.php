<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserActivities extends Migration
{
    
    public function up()
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->foreignId( 'user_id' )->change()->nullable()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        //
    }
}
