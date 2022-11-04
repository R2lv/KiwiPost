<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(){

        $this->middleware('auth');

    }

    public function show() {
        $addresses =  Address::with('country')->orderBy('id','desc')->get();

        return [
            'success'=>true,
            'result'=>[
                'addresses'=>$addresses,
                'user'=>[
                    'balance'=>auth()->user()->balance,
                    'id'=>auth()->user()->id,
                    'name'=>auth()->user()->name,
                    'lastname'=>auth()->user()->surname
                ],
            ],
            'error'=>null,
        ];
    }
}
