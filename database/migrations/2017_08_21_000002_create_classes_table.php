<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->string('class_id', 5);
            $table->string('course_sec');
            $table->integer('instructor_id')->unsigned();   //instructor_id comes from users table
            $table->integer('subject_id')->unsigned();
            $table->boolean('class_active');
            $table->primary('class_id');
        });
        Schema::table('classes', function(Blueprint $table){
            $table->foreign('instructor_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
