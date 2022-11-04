<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslateController extends Controller
{
    //

    public function index(Request $request, $lang) {


		$cookie = cookie('lang', $lang, 0, null, null, false, false);

//		dd($lang);

		return redirect()->back()->cookie($cookie);

    		
    }
}
