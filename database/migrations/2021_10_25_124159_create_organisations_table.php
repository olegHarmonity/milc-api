<?php

use App\Util\CompanyStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('organisation_name');
            $table->string('registration_number');
            $table->string('phone_number')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('organisation_role');
            $table->string('description');
            $table->string('website_link');
            $table->json('social_links');
            $table->dateTime('date_activated')->nullable();
            $table->string('status')->default(CompanyStatuses::$PENDING);
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('organisation_type_id')->unsigned();
            $table->integer('logo_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisations');
    }
}
