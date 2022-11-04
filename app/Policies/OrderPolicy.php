<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    public static function create()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_ADD) === $user->roles;

        };
    }


    public static function show() {
        return function(User $user, Order $order) {
			if (($user->roles | app('roles')->PARCEL_ADD) === $user->roles)
				return true;
            return $order->user_id == $user->id;
        };
    }
}
