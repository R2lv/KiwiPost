<?php

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('addresses')->insert([
            'country_id' => '1',
            'address_1_en' => 'A. Tsagareli #60',
            'address_1_ka' => ' ა. ცაგარელის ქუჩა #60',
            'address_2_en'=>'',
            'address_2_ka'=>'',
            'city_en' => 'Tbilisi',
            'city_ka' => 'თბილისი',
            'state_en' => 'Saburtalo',
            'state_ka' => 'საბურთალო',
            'zip' => '0160',
            'phone' => '2052324',
        ]);
        DB::table('addresses')->insert([
            'country_id' => '2',
            'address_1_en' => '19 New College Parade',
            'address_1_ka' => '19 New College Parade',
            'address_2_en'=>'Finchley Road',
            'address_2_ka'=>'Finchley Road',
            'city_en' => 'London',
            'city_ka' => 'London',
            'state_en' => 'London',
            'state_ka' => 'London',
            'zip' => 'NW3 5EP',
            'phone' => '+44 20 7449 0312',
        ]);


    }
}
