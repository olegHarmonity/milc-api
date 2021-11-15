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
            $table->foreignId('logo_id')->nullable()->references('id')->on('images');
            $table->foreignId('organisation_type_id')->nullable()->references('id')->on('organisation_types');
            
            $table->string('organisation_name');
            $table->string('registration_number');
            $table->string('phone_number')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('organisation_role');
            $table->string('description');
            $table->string('website_link')->nullable();
            $table->json('social_links')->nullable();
            $table->dateTime('date_activated')->nullable();
            $table->string('status')->default(CompanyStatuses::$PENDING);
            $table->string('country');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
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
