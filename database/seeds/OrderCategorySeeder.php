<?php

use Illuminate\Database\Seeder;

class OrderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('order_categories')->insert([
            'order_id'=>1,
            'category_id'=>1,
        ]);


        DB::table('order_categories')->insert([
            'order_id'=>1,
            'category_id'=>2,
        ]);


        DB::table('order_categories')->insert([
            'order_id'=>2,
            'category_id'=>1,
        ]);

        DB::table('order_categories')->insert([
            'order_id'=>2,
            'category_id'=>3,
        ]);
        DB::table('order_categories')->insert([
            'order_id'=>2,
            'category_id'=>4,
        ]);

    }
}
