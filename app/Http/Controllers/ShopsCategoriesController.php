<?php

namespace App\Http\Controllers;

use App\ShopsCategories;
use Illuminate\Http\Request;
use Gate;
class ShopsCategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
        $this->middleware('roles',['except'=>['index']]);
    }
    public function index()
    {
        $order_by = 'title_en';
        if(app()->getLocale() == 'ka'){
            $order_by = 'title_ka';
        }
        $cats = ShopsCategories::query()->select(['title_en','title_ka','id'])->with(['shops'=>function($query){
            return $query->select(['title','url'])->orderBy('title','ASC');
        }])->orderBy($order_by,'ASC')->get();
        return $this->success($cats);

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
                'title_en' => 'required',
                'title_ka' => 'required'
            ];
            $validator = \Validator::make($request->input(), $rules);

            if ($validator->fails()) {
                return $this->failure($validator->messages());
            }else{
                $cats = ShopsCategories::query()->create($request->only(['title_en','title_ka']));
                if($cats){
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
     * @param  \App\ShopsCategories  $shopsCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ShopsCategories $shopsCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShopsCategories  $shopsCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopsCategories $shopsCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShopsCategories  $shopsCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopsCategories $shopsCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShopsCategories  $shopsCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopsCategories $shopsCategories)
    {
        //
    }
}
