<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            OrdersSeeder::class,
            CategorySeeder::class,
            OrderCategorySeeder::class,
            TrustedListsSeeder::class
        ]);

        DB::table('parameters')->insert([
            'price_list_personal'=>"[{\"from\":\"UK\",\"to\":\"GE\",\"from_home_per_kg\":\"0.6\",\"home_delivery_per_kg\":0.5,\"prices\":[{\"from\":0,\"to\":0.2,\"price\":0.75},{\"from\":0.2,\"to\":5,\"price\":2.5},{\"from\":5,\"to\":\"Infinity\",\"price\":2}]},{\"from\":\"GE\",\"from_home_per_kg\":0.5,\"to\":\"UK\",\"prices\":[{\"from\":0,\"to\":\"50\",\"price\":5},{\"from\":50,\"to\":\"200\",\"price\":4.5},{\"from\":200,\"to\":\"500\",\"price\":4}]}]",
            'price_list_online'=>"[{\"from\":\"UK\",\"to\":\"GE\",\"home_delivery\":[{\"from\":0,\"to\":5,\"price\":0.85},{\"from\":5,\"to\":10,\"price\":1.4},{\"from\":10,\"to\":22,\"price\":2.85}],\"prices\":[{\"from\":0,\"to\":0.2,\"price\":0.75},{\"from\":0.2,\"to\":\"Infinity\",\"price\":3.75}]},{\"from\":\"GE\",\"to\":\"UK\",\"prices\":[{\"from\":0,\"to\":\"50\",\"price\":5},{\"from\":50,\"to\":\"200\",\"price\":4.5},{\"from\":200,\"to\":\"500\",\"price\":4}]}]",
            'home_delivery'=>""
        ]);
    }
}
