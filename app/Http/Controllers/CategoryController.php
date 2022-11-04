<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){

        $this->middleware('auth');

    }

    public function show() {
        $categories = Category::all();

        dd($categories);
    }
}
