<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_classes', function (Blueprint $table) {
            $table->string('class_id', 5);
            $table->integer('student_id')->unsigned();  //student ID comes from users table
        });
        Schema::table('student_classes', function(Blueprint $table){
            $table->foreign('student_id')->references('usr_id')->on('users');
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_classes');
    }
}
