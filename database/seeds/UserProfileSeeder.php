<?php

use Illuminate\Database\Seeder;

use App\UserProfile;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserProfile::create([
            'usr_id' => 2,
            'given_name' => 'Emir',
            'family_name' => 'Jo',
            'middle_name' => 'M.',
            'ext_name' => 'Jr.',
        ]);
        UserProfile::create([
            'usr_id' => 3,
            'given_name' => 'Given',
            'family_name' => 'Family',
            'middle_name' => 'M.',
            'ext_name' => 'Ext.',
        ]);
    }
}
