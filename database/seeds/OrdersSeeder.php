<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('orders')->insert([
            'user_id'=>1,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>1,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'weight'=>32,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
        ]);

        DB::table('orders')->insert([
            'user_id'=>1,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>2,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'weight'=>32,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
        ]);

        DB::table('orders')->insert([
            'user_id'=>2,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>2,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'weight'=>32,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        ]);

        DB::table('orders')->insert([
            'user_id'=>2,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>2,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'home_delivery'=>true,
            'weight'=>32,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        ]);

        DB::table('orders')->insert([
            'user_id'=>2,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>2,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'weight'=>32,
            'home_delivery'=>true,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        ]);

        DB::table('orders')->insert([
            'user_id'=>2,
            'type'=>0,
            'status'=>'waiting',
            'trusted_id'=>2,
            'operator_id'=>1,
            'from_country_id'=>1,
            'to_country_id'=>2,
            'parcel_cost'=>12,
            'paid'=>false,
            'weight'=>32,
            'obtain_cost'=>55,
            'obtain_currency'=>'GBP',
            'obtain_webstore'=>'amazon.co.uk',
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        ]);


    }
}
