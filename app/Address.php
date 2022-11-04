<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Address extends Model
{
    //
    protected $appends = ['city','address','address_second','state'];


    public function getCityAttribute() {
        return $this->{'city_'.app()->getLocale()};
    }


    public function getAddressAttribute() {
        return $this->{'address_1_'.app()->getLocale()};
    }

    public function getAddressSecondAttribute() {

        return $this->{'address_2_'.app()->getLocale()};
    }


    public function getStateAttribute() {
        return $this->{'state_'.app()->getLocale()};
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }


}
