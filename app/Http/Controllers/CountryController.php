<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(){

//
    }

    public function show(){
        $countries = Country::all();
        return [
            'success'=>true,
            'result'=>$countries,
            'error'=>null
        ];
    }
}
