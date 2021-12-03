<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleRightsInformation extends Migration
{
    public function up()
    {
        Schema::create('bundle_rights_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('rights_bundle_id')->nullable()->references('id')->on('rights_bundles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('rights_information_id')->nullable()->references('id')->on('rights_information')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bundle_rights_information');
    }
}
