<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unicard extends Model
{
    //
    protected $fillable = ['user_id','transporting_cost','trans_id_stan','amount','stats','message','unicardNumber'];
}
