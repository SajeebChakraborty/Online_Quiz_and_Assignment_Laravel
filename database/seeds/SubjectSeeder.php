<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([[
            'subject_id' => 1,
            'subject_code' => 'CSIT 131',
            'subject_desc' => 'Web Development'
        ]]);
    }
}
