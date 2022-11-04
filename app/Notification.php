<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    //
    protected $fillable = [
        'user_id',
        'status','priority','title_en','title_ka','text_en','text_ka',
        'button_action','button_text_en','button_text_ka','button_close','button_url',
        'button_2_action', 'button_2_text_en','button_2_text_ka','button_2_close','button_2_url',
        'type'];

    protected $appends = ['button_text','button_2_text','title','text'];

    public function getButtonTextAttribute() {
        return $this->{'button_text_'.app()->getLocale()};
    }
    public function getButton2TextAttribute() {
        return $this->{'button_2_text_'.app()->getLocale()};
    }

    public function getTitleAttribute() {
        return $this->{'title_'.app()->getLocale()};
    }

    public function getTextAttribute() {
        return $this->{'text_'.app()->getLocale()};
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}

