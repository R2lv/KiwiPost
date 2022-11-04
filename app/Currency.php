<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
    protected $fillable = ['USDGBP','USDGEL','GBPUSD','GBPGEL','GELGBP','USDEUR','EURGBP','EURUSD','EURGEL','GELUSD','GELEUR'];
}
