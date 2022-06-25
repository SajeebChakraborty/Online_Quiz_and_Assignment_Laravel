<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizStudentAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_student_answers', function (Blueprint $table) {
            $table->integer('student_id')->unsigned();
            $table->integer('quiz_event_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('student_answer');
        });
        Schema::table('quiz_student_answers', function(Blueprint $table){
            $table->foreign('student_id')->references('usr_id')->on('users');
            $table->foreign('quiz_event_id')->references('quiz_event_id')->on('quiz_events')->onDelete('cascade');
            $table->foreign('question_id')->references('question_id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_student_answers');
    }
}
