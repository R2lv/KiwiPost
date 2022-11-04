<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $appends = ['name'];

    public function getNameAttribute() {
        return $this->{'name_'.app()->getLocale()};
    }
}
