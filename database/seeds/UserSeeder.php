<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([

            'name' => 'Sandro',
            'surname' => 'Antidze',
            'password' => bcrypt('qweasd123'),
            'email' => 'sandro.antidze@icloud.com',
            'country_id' => '1',
            'address_1' => 'kavtaradze 25',
            'address_2' => '',
            'personal_number' => '61000000000',
            'postcode' => '0160',
            'city_town' => 'Tbilisi',
            'mobile' => '+995 555999000',
            'roles'=>'255'
        ]);

        DB::table('users')->insert([
            'name' => 'George',
            'surname' => 'Tabatadze',
            'password' => bcrypt('qweasd123'),
            'email' => 'android.giorgi@gmail.com',
            'country_id' => '1',
            'address_1' => 'kavtaradze 25 a',
            'address_2' => '',
            'personal_number' => '53000000000',
            'postcode' => '0161',
            'city_town' => 'Tbilisi',
            'mobile' => '+995 444999000',
            'roles'=>'255'
        ]);

        DB::table('users')->insert([
            'name' => 'IRMA',
            'surname' => 'chomakhidze',
            'password' => '$2y$10$pLORh/w0QDfvhRahxZaIO.mo9VbuJQg9D60bz97g79hMd28rNwc6.',
            'email' => 'irmachomakhidze@gmail.com',
            'country_id' => '2',
            'address_1' => '143 WULFSTAN STREET',
            'address_2' => 'EAST ACTON',
            'personal_number' => '01017007434',
            'postcode' => 'W12 0AB',
            'city_town' => 'LONDON',
            'mobile' => '445',
        ]);
    }
}
