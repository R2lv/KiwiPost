<?php

namespace App\Http\Controllers;

use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Pages;

class NewsController extends Controller
{
    public function __construct(){

        $this->middleware('roles',['except'=>['index','show']]);

    }
    public function index()
    {


        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);

        $news = News::query()->orderBy('id','desc')->paginate(15);
        $params['news'] = $news;
        return view("pages/news-list", $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
        $newses = News::query()->orderBy('id','desc')->limit(6)->get();
        $params['current'] = $news;

        $params['news'] = $newses;

        $content = Pages::query()->where('name','home')->first();
        $params['dataSlider'] = json_decode($content->data,true);

        return view('pages/news-single',$params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
