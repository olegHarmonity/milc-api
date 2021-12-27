<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Util\UserStatuses;

class UserStatusChange extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('status')->default(UserStatuses::$ACTIVE)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->string('status')->default(UserStatuses::$INACTIVE)->change();
        });
    }
}
