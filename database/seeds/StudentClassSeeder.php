<?php

use Illuminate\Database\Seeder;

use App\StudentClass;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentClass::create([
            'student_id' => 3,
            'class_id' => "3KMMR"
        ]);
    }
}
