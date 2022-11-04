<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');

    }

    public function index() {

        $country = Country::all();

        return $this->success($country);
    }

}
