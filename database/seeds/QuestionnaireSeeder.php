<?php

use Illuminate\Database\Seeder;

use App\Questionnaire;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Questionnaire::create([
            'questionnaire_name' => 'HTML Basics'
        ]);
    }
}
