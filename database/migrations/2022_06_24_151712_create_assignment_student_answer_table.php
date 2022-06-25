<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentStudentAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_student_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('assignment_event_id')->nullable();
            $table->string('assignment_description')->nullable();
            $table->string('student_answer')->nullable();
            $table->string('student_id')->nullable();
            $table->string('student_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_student_answers');
    }
}
