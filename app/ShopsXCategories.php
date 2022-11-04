<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ShopsXCategories extends Model
{
    protected $table = 'shops_x_categories';
    protected $fillable = ['shop_id','category_id'];


}
