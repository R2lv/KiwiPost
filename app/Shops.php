<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    //
    protected $fillable = ['title','url'];

    public function categories(){
        return $this->belongsToMany(ShopsCategories::class,'shops_x_categories','shop_id','category_id');
    }
}
