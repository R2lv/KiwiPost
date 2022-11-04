<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Msge;

class UsersController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('roles');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Gate::allows('SEE_USERS') || Gate::allows('PARCEL_VIEW_ALL')){
            $search = User::query()->with(['orders']);

        } else {
            return $this->permissionDenied();
        }



        if($request->has('search')){

           $words = $request->get('search');

           $dts = $pieces = explode(" ", $words);
           foreach ($dts as $dt) {
               $search = $search->where('name', 'LIKE', '%' . $dt . '%')
                   ->orWhere('email', 'LIKE', '%' . $dt . '%')
                   ->orWhere('surname', 'LIKE', '%' . $dt . '%')
                   ->orWhere('address_1', 'LIKE', '%' . $dt . '%')
                   ->orWhere('address_2', 'LIKE', '%' . $dt . '%')
//                            ->orWhere('country','LIKE','%'.$dt.'%')
                   ->orWhere('personal_number', 'LIKE', '%' . $dt . '%')
                   ->orWhere('postcode', 'LIKE', '%' . $dt . '%')
                   ->orWhere('city_town', 'LIKE', '%' . $dt . '%')
                   ->orWhere('unicard', 'LIKE', '%' . $dt . '%')
                   ->orWhere('mobile', 'LIKE', '%' . $dt . '%')
                   ->orWhere('mobile_2', 'LIKE', '%' . $dt . '%');
           }
        }

        if($request->has('room')){

            $room = $request->get('room');
            $search = $search->where('id',$room);

        }
        return $this->success($search->orderBy('id','desc')->paginate(55));

    }

    public function stats() {
        $all_users = User::query()->where('temp',1)->get();
        $registered_users = User::query()->where('temp',0)->get();
        return $this->success([
            'users_total'=>$all_users->count(),
            'registered'=>$registered_users->count()
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::allows('ALL',auth()->user())){

            return $this->success('success role is added dear bear');
        }
        return $this->permissionDenied();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request) {
        $string = $request->input('s');

        $user = User::query()->where(DB::raw("CONCAT(`name`, ' ', `surname`)"), "LIKE", "%{$string}%")->get();

        return $this->success($user);

    }

    public function messageAllUsers(){


    }

}
