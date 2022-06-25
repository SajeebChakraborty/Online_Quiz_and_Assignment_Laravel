<?php

use Illuminate\Database\Seeder;

class QuizEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiz_events')->insert([[
            'quiz_event_id' => 1,
            'quiz_event_name' => 'HTML Basics',
            'questionnaire_id' => 1,
            'quiz_event_status' => 0,//pending quiz
            'class_id' => "3KMMR",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]]);
    }
}
