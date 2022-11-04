<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use \Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('roles');

    }
 
    
    public function index(Request $request, $all = 'home') {

        $roles = [];
        foreach (config('defaults.roles') as $key => $value) {
            $roles[$key] =  (auth()->user()->roles | $value) === auth()->user()->roles;
        }

        if($request->is('master/home')) {
            $redirect = "";
            switch(true) {
                case $this->can('VIEW_STATISTICS'):
                    break;
                case $this->can('PARCEL_ADD'):
                    $redirect = "/master/order";
                    break;
                case $this->can('ARTICLE_ADD'):
                case $this->can('SEE_USERS'):
                    $redirect = "/master/news";
                    break;
                default:
                    $redirect = "/";
                    break;
            }

            if(!empty($redirect)) {
                return redirect($redirect);
            }
        }

        return view('admin.home', [
            'roles' => $roles
        ]);
    }

    public function can($str) {
        return Gate::allows("ALL") || Gate::allows($str);
    }


    public function addOrder(Request $request) {

        if(Gate::allows('PARCEL_ADD')){

            $rules = [
                'room_number' => 'required',
                'weight' => 'required',
            ];

            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

                return $this->failure($validator);

            }else{
                $id = (integer)'50605439800000000' + (integer)'222'; // unic id
                $tracking_number = str_pad($id, 18, '0', STR_PAD_LEFT);
                $result = '';
                return $this->success($result);
            }

        }

        return $this->permissionDenied();
    }


    public function destroyOrder(Request $request) {

        if(Gate::allows('PARCEL_DELETE')) {


            return $this->success('dear jorge');

        }

        return $this->permissionDenied();
    }



}
