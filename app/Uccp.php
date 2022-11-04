<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uccp extends Model
{
    //
    protected $fillable = ['user_id','amount_GBP','amount_gel','status','unicId'];
}
