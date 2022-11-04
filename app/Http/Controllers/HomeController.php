<?php

namespace App\Http\Controllers;

use App\ShopsCategories;
use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\Auth;
use App\Pages;
use App\Shops;
use App\ShopsXCategories;

class HomeController extends Controller
{

    public function __construct(){

        $this->middleware('auth', ['only'=>['dashboard']]);
        $this->middleware('guest',['only'=>'home']);
        $this->middleware('secureUrl');

    }


    private $components = [
        'auth'=>['add-package','edit-profile'],
        'guest'=>['login','register'],
        'any'=>['contact']
    ];
    public function popup($page) {

        if(!in_array($page, $this->components['any'])) {
            if (!Auth::check()) {
                if (!in_array($page, $this->components['guest'])) {
                    return abort(404);
                }
            } else {
                if (!in_array($page, $this->components['auth'])) {
                    return redirect('/');
                }
            }
        }

        $news = News::query()->orderBy('id','desc')->limit(6)->get();

        $content = Pages::query()->where('name','home')->first();
//        $params['dataSlider'] = json_decode($content->data,true);
        $params['data']['title'] = 'login';
        $params['news'] = $news;
        $params['page'] = $page;
        $params['dataSlider'] = json_decode($content->data,true);
        return view('pages.component', [
            'news'=>$news,
            'page'=>$page,
            'title'=>$page,
            'dataSlider' => json_decode($content->data,true),
        ]);
    }

    public function home()
    {
        //
        $params = [];
        if(old('data')) {
            $params['data'] = old('data');
        }
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['news'] = $news;
        $content = Pages::query()->where('name','home')->first();
        $params['data'] = json_decode($content->data,true);
        $params['data']['title'] = $content->title;

        return view('pages/index',  $params);
    }

    public function login() {
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        return view('pages.login', [
            'news'=>$news
        ]);
    }
    public function form_register() {
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        return view('pages.register', [
            'news'=>$news
        ]);
    }

    public function register() {

    }

    public function dashboard()
    {
        $params = [];
        if(old('data')) {
            $params['data'] = old('data');
        }

        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['news'] = $news;

        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);
//dd($params['dataSlider']['online_stores']);
        return view("pages/dashboard", $params);
    }

//    public function news() {
//
//        return view("pages/news-list");
//    }
//    public function singleNews() {
//
//        return view("pages/news-single");
//    }

    public function faq() {
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['news'] = $news;

        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);
        return view('pages/faq', $params);
    }

    public function about() {  // todo aply font
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['news'] = $news;

        $content = Pages::query()->where('name','about')->first();
        $params['data'] = json_decode($content->data,true);
        $params['data']['title'] = $content->title;
        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);

        return view('pages.about', $params);
    }

    public function pricing() {  // todo aply font
        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['news'] = $news;
        $content = Pages::query()->where('name','pricing')->first();
        $params['pricing'] = json_decode($content->data,true)['pricing'];
        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);
        return view('pages.pricing', $params);
    }



    public function contacts() {

        $news = News::query()->orderBy('id','desc')->limit(6)->get();
        $params = ['news'=>$news];
        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);
        return view('pages.contacts', $params);
    }

    public function shops() {
		$news = News::query()->orderBy('id','desc')->limit(6)->get();
		$params = ['news'=>$news];
        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);
    	return view('pages.shops', $params);
	}

	public function getAllFaq(){
        $content = Pages::query()->where('name','faq')->first();
        $param = [];
        $param['questions']=json_decode($content->data,true);
        return $this->success($param);
    }

    public function sitemap(){
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">
    <!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->


    <url>
        <loc>https://kiwipost.ge/</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/about</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/pricing</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/shops</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/faq</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/news</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/contacts</loc>
        <lastmod>2018-08-14T07:39:05+00:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>https://kiwipost.ge/KIWIPOST-TERMS-EN.pdf</loc>
        <lastmod>2017-12-20T13:50:21+00:00</lastmod>
        <priority>0.64</priority>
    </url>


</urlset>";
        return response($content)
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
    }


}
