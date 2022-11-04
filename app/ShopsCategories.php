<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopsCategories extends Model
{
    protected $fillable = ['title_en','title_ka'];

    protected $appends = ['title'];

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }

    public function shops(){
        return $this->belongsToMany(Shops::class,'shops_x_categories','category_id','shop_id');
    }

}
