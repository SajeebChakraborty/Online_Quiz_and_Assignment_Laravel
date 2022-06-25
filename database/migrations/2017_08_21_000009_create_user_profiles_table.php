<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integer('usr_id')->unsigned();
            $table->string('given_name');
            $table->string('family_name');
            $table->string('middle_name');
            $table->string('ext_name')->nullable();
        });
        Schema::table('user_profiles', function(Blueprint $table){
            $table->foreign('usr_id')->references('usr_id')->on('users')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
