<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'name_en'=>'Electronix',
            'name_ka'=>'ელექტროობა',
        ]);
        DB::table('categories')->insert([
            'name_en'=>'Auto parts',
            'name_ka'=>'ავტო ნაწილები',
        ]);
        DB::table('categories')->insert([
            'name_en'=>'Clothes',
            'name_ka'=>'ტანსაცმელი',
        ]);
        DB::table('categories')->insert([
            'name_en'=>'Sport accessories',
            'name_ka'=>'სპორტის აქსესუარები',
        ]);
    }
}
