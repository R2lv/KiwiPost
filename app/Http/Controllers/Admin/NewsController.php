<?php

namespace App\Http\Controllers\Admin;

use App\News;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('roles');
    }
    public function index()
    {
        //
        $news = News::query()->paginate(15);

        return $this->success($news);
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'title_en' => 'required',
            'title_ka' => 'required',
            'list_description_en' => 'required',
            'list_description_ka' => 'required',
            'full_description_en' => 'required',
            'full_description_ka' => 'required',
//            'image'=>'required|image|mime:jpg,jpeg,png'
        ];
        $values = array_keys($rules);
        $validator = \Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return $this->failure($validator->messages());

        } else {

             if($request->hasFile('image')) {

                 $file = $request->file("image");
                 $fileName = '/' . Storage::disk('public')->put('news-images', $file);
                 $all = $request->only($values);
                 $all['image_url'] = $fileName;

                 News::query()->create($all);
                 return $this->success(['Success']);
             }
             return $this->failure("image error");
        }
    }


    public function edit(News $news)
    {
        return $this->success($news);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = [
            'title_en' => 'required',
            'title_ka' => 'required',
            'list_description_en' => 'required',
            'list_description_ka' => 'required',
            'full_description_en' => 'required',
            'full_description_ka' => 'required',
            'image'=>'image|mime:jpg,jpeg,png'
        ];
        $values = array_keys($rules);
        $validator = \Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return $this->failure($validator->messages());

        } else {

            $news = News::find($id);

            if($news){
                $all = $request->only($values);
                if($request->hasFile('image')) {
                    File::delete(public_path('') . $news->image_url);

                    $file = $request->file("image");
                    $fileName = '/' . Storage::disk('public')->put('news-images', $file);
                    $all['image_url'] = $fileName;
                }

                $news->update($all);
                return $this->success(['Success']);

            }else{
                return $this->failure(['image'=>['image not exists']]); // todo translate
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
//        dd($news->image_url);
        File::delete(public_path('').$news->image_url);
        $news->delete();
        return $this->success(['delete success']); // todo trans

    }
}
