<?php

namespace App\Http\Controllers;

use App\Shops;
use Illuminate\Http\Request;
use Gate;

class ShopsController extends Controller
{

    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
        $this->middleware('roles',['except'=>['index']]);
    }


    public function index()
    {
        //

        return $this->success(Shops::query()->select(['title','url','id'])->with(['categories'])->orderBy('title','ASC')->get());
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
        if(Gate::allows('PARCEL_VIEW_ALL')) {

            $rules = [
                'title' => 'required',
                'url' => 'required',
            ];
            $validator = \Validator::make($request->input(), $rules);

            if ($validator->fails()) {
                return $this->failure($validator->messages());
            }else{

//                return 'we are here';
                $shops = Shops::query()->create($request->only(['title','url']));

                if($request->get('category_ids')) {
                    $shops->categories()->sync($request->get('category_ids'));
                }

                if($shops){
                    return $this->success('success');
                }else{
                    return $this->failure('failure');
                }
            }


        }
        return $this->permissionDenied();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shops  $shops
     * @return \Illuminate\Http\Response
     */
    public function show(Shops $shops)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shops  $shops
     * @return \Illuminate\Http\Response
     */
    public function edit(Shops $shops)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shops  $shops
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shops $shops)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shops  $shops
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shops $shops)
    {
        //
    }
}
