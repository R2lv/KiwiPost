<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //

    protected $appends = ['data','title'];

    public function getDataAttribute(){
        return $this->{'data_'.app()->getLocale()};
    }


    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }
}
