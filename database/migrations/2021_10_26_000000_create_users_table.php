<?php

use App\Util\UserRoles;
use App\Util\UserStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'organisation_id' )->nullable()->constrained('organisations');
            $table->foreignId('image_id')->unsigned()->nullable()->references('id')->on('images');
            
            $table->string('role')->default(UserRoles::$ROLE_USER);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('job_title')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('password');
            $table->string('status')->default(UserStatuses::$INACTIVE);
            $table->rememberToken();
            $table->timestamps();
        });
            
            
        Schema::table('organisations', function(Blueprint $table) {
            $table->foreignId('organisation_owner_id')->unsigned()->nullable()->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
