<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name_en' => 'Georgia',
            'name_ka' => 'საქართველო',
            'code'=>'GE'
        ]);
        DB::table('countries')->insert([
            'name_en' => 'United Kingdom',
            'name_ka' => 'გაერთიანებული სამეფო',
            'code'=>'UK'
        ]);
    }
}
