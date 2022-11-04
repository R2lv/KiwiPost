<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $appends = ['name'];
    public function orders() {

        return $this->belongsToMany(Order::class,'order_categories');

    }

    public function getNameAttribute() {

        return $this->{'name_'.app()->getLocale()};

    }
}
