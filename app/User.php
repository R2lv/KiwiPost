<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
        'country_id','name','surname','address_1','address_2','personal_number','postcode','city_town',
        'mobile','mobile_2','mobile_token','telephone','balance','newsletter','roles','email_token','email_verified','email_verification_count','temp','unicard' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }


    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function trustedUsers() {
        return $this->hasMany(TrustedList::class);

    }

    public function passwordResets() {

        return $this->hasMany( PasswordReset::class,'email','email');

    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function payment() {
        return $this->hasMany(Payment::class);
    }
}
