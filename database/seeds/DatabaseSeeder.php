<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(UserProfileSeeder::class);
         $this->call(SubjectSeeder::class);
         $this->call(ClassSeeder::class);
         $this->call(StudentClassSeeder::class);
         $this->call(QuestionnaireSeeder::class);
         $this->call(QuestionSeeder::class);
         $this->call(QuizEventSeeder::class);
    }
}
