<?php

namespace App\Http\Controllers\Admin;

use App\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ParametersController extends Controller
{

    public function __construct(){

        $this->middleware('auth',['except'=>['index']]);

    }

    public function index()
    {
        //

        $parameter = Parameter::query();
        $params = $parameter->select('price_list_personal','price_list_online','home_delivery')->where('id',1)->get()[0];


        $personal = json_decode($params->price_list_personal,true);
        $online = json_decode($params->price_list_online, true);
        $home_delivery = json_decode($params->home_delivery, true);


        return $this->success([
            'personal'=>$personal,
            'online'=>$online,
            'home_delivery'=>$home_delivery
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
        //
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
}
