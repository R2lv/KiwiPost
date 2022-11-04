<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\TrustedList;
use Illuminate\Http\Request;

class DataFlowController extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth', [
            'except'=>['countries']
        ]);

    }

    public function show() {
        $categories = Category::all();
        $countries = Country::query()->orderBy('id','desc')->get();
        $trusted_lists = TrustedList::where('user_id',auth()->user()->id)->get();
        return [
            'success'=>true,
            'result'=>['categories'=>$categories,'countries'=>$countries,'trusted'=>$trusted_lists],
            'error'=>''
        ];
    }

    public function countries() {

        $countries = Country::all();

        return [
            'success'=>true,
            'result'=>$countries,
            'error'=>''
        ];

    }
}
