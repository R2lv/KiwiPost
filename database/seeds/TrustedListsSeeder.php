<?php

use Illuminate\Database\Seeder;

class TrustedListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('trusted_lists')->insert([
            'user_id'=>1,
            'name'=>"irma",
            'surname'=>'lomtatidze',
            'mobile'=>'555555444',
        ]);

        DB::table('trusted_lists')->insert([
            'user_id'=>1,
            'name'=>"nino",
            'surname'=>'antidze',
            'mobile'=>'3322332233',
        ]);


        DB::table('trusted_lists')->insert([
            'user_id'=>2,
            'name'=>"khatuna",
            'surname'=>'barbakadze',
            'mobile'=>'55445566',
        ]);
    }
}
