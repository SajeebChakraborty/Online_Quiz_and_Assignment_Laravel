<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_events', function (Blueprint $table) {
            $table->increments('assignment_event_id');
            $table->string('assignment_even_name')->nullable();
            $table->string('teacher_id')->nullable();
            $table->longText('assignment_description')->nullable();
            $table->string('assignment_file')->nullable();
            $table->string('class_id')->nullable();
            $table->string('assignment_last_date')->nullable();
            $table->string('assignment_event_status')->nullable();
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
        Schema::dropIfExists('assignment_events');
    }
}
