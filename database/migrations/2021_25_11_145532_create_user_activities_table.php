<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Util\UserActivities;

class CreateUserActivitiesTable extends Migration
{

    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId( 'user_id' )->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('activity')->default(UserActivities::$LOGIN);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
}
