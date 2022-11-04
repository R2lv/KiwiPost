<?php

namespace App\Http\Controllers;

use App\TrustedList;
use Illuminate\Http\Request;

class TrustedListController extends Controller
{

    public function __construct(){

        $this->middleware('auth');

    }


}
