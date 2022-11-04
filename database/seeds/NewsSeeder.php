<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'',
            'list_description_en'=>'',
            'list_description_ka'=>'',
            'full_description_en'=>'',
            'full_description_ka'=>'',
            'image_url'=>"https://www.dontpayfull.com/blog/wp-content/uploads/2016/04/Secret-Shopping-Tricks.jpg",
        ]);

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'',
            'list_description_en'=>'',
            'list_description_ka'=>'',
            'full_description_en'=>'',
            'full_description_ka'=>'',
            'image_url'=>"https://www.zeroweb.gr/wp-content/uploads/2017/10/e-shop-banner.jpg",
        ]);

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'',
            'list_description_en'=>'',
            'list_description_ka'=>'',
            'full_description_en'=>'',
            'full_description_ka'=>'',
            'image_url'=>"https://media.licdn.com/mpr/mpr/AAEAAQAAAAAAAA2tAAAAJGEyMmU3M2U2LTBlNmItNDVkNS05YjNlLWMxYzA4N2JiYmQ5Mg.jpg",
        ]);

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'ბრიტანულ ონლაინ მაღაზიებში შოპინგის 5 მიზეზი',
            'list_description_en'=>'',
            'list_description_ka'=>'',
            'full_description_en'=>'',
            'full_description_ka'=>'',
            'image_url'=>"/news-images/u45pT0vHIhpytWsdsjH5a87Gdx6JQak0OueZLkiv.jpeg",
        ]);

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'როგორ გავყიდოთ საკუთარი პროდუქცია ბრიტანეთში',
            'list_description_en'=>'ონლაინ შოპინგი უკვე რამდენიმე წელია აქტიურად შემოიჭრა ჩვენს ყოველდღიურობაში და ძალიან ხშირად, როდესაც რაიმე კონკრეტული ნივთის შეძენა გვსურს, პირველ რიგში პოპულარულ შოპინგ საიტებს მივმართავთ. დღეს გვსურს ვისაუბროთ იმ რამდენიმე მიზეზზე, თუ რატომ უნდა შეიძინოთ ნივთები ბრიტანეთის ონლაინ მაღაზიებში',
            'list_description_ka'=>'ონლაინ შოპინგი უკვე რამდენიმე წელია აქტიურად შემოიჭრა ჩვენს ყოველდღიურობაში და ძალიან ხშირად, როდესაც რაიმე კონკრეტული ნივთის შეძენა გვსურს, პირველ რიგში პოპულარულ შოპინგ საიტებს მივმართავთ. დღეს გვსურს ვისაუბროთ იმ რამდენიმე მიზეზზე, თუ რატომ უნდა შეიძინოთ ნივთები ბრიტანეთის ონლაინ მაღაზიებში',
            'full_description_en'=>"",
            'full_description_ka'=>'',
            'image_url'=>"/news-images/gi51thCkvYmFtJGf0t9vAsHMcB99nWXGnJiP1mZY.jpeg",
        ]);

        DB::table('news')->insert([
            'title_en'=>'',
            'title_ka'=>'შავი პარასკევი და რამდენიმე რჩევა, ამ დღეს შოპინგისთვის',
            'list_description_en'=>'',
            'list_description_ka'=>'',
            'full_description_en'=>'',
            'full_description_ka'=>'',
            'image_url'=>"/news-images/9czFv7aljiqN56JcyQhEfZ3XFy7ju6YMgUwUekwx.jpeg",
        ]);


    }
}
