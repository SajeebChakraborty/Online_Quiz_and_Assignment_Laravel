<?php

use Illuminate\Database\Seeder;

use App\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::create([
            'questionnaire_id' => 1,
            'question_name' => 'What does HTML stand for?',
            'question_type' => 2,
            'choices' => 'Hypertext Marking Language;Hypertext Tool Management Language;Hypertext Markup Language;Hidden Text-Making Language',
            'answer' => 3,
            'points' => 1
        ]);

        Question::create([
            'questionnaire_id' => 1,
            'question_name' => 'What is the correct HTML element for the largest heading?',
            'question_type' => 1,
            'choices' => null,
            'answer' => '<h1>',
            'points' => 2
        ]);

        Question::create([
            'questionnaire_id' => 1,
            'question_name' => '<br> breaks a line.',
            'question_type' => 3,
            'choices' => null,
            'answer' => 1,
            'points' => 2
        ]);

        Question::create([
            'questionnaire_id' => 1,
            'question_name' => 'Bootstrap is developed by Acme Inc.',
            'question_type' => 3,
            'choices' => null,
            'answer' => 0,
            'points' => 2
        ]);

        Question::create([
            'questionnaire_id' => 1,
            'question_name' => 'What is 1 + 1?',
            'question_type' => 2,
            'choices' => '2;11;2 and 11;None specified',
            'answer' => 3,
            'points' => 2
        ]);
    }
}
