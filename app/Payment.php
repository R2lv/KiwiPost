<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $fillable = ['user_id','transaction_id','amount','status_code','native_currency','native_amount'];


    public function user () {
        return $this->belongsTo(User::class);
    }
}
