<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePersonDelete extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_info_writers', function (Blueprint $table) {
            $table->foreignId('person_id')
                ->change()
                ->nullable()->onDelete('set null');
        });
        
        Schema::table('production_info_cast', function (Blueprint $table) {
            $table->foreignId('person_id')
                ->change()
                ->nullable()->onDelete('set null');
        });
        
        Schema::table('production_info_directors', function (Blueprint $table) {
            $table->foreignId('person_id')
                ->change()
                ->nullable()->onDelete('set null');
        });
        
        Schema::table('production_info_producers', function (Blueprint $table) {
            $table->foreignId('person_id')
                ->change()
                ->nullable()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
