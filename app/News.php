<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $fillable = ['title_en','title_ka','list_description_en','list_description_ka','full_description_en','full_description_ka','image_url'];

    protected $appends = ['title','list_description','full_description','date'];

    public function getTitleAttribute() {
        return $this->{'title_'.app()->getLocale()};
    }
    public function getListDescriptionAttribute() {
        return $this->{'list_description_'.app()->getLocale()};
    }
    public function getFullDescriptionAttribute() {
        return $this->{'full_description_'.app()->getLocale()};
    }

    public function getDateAttribute() {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at)->format('d-m-Y');
    }
}
