<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public static function parcelAdd()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_ADD) === $user->roles;

        };
    }

    public static function parcelDelete()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_DELETE) === $user->roles;

        };
    }

    public static function parcelViewAll()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_VIEW_ALL) === $user->roles;

        };
    }

    public static function parcelChangeStatus()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_CHANGE_STATUS) === $user->roles;

        };
    }

    public static function seeUsers()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->SEE_USERS) === $user->roles;

        };
    }

    public static function parcelMakePayment()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_MAKE_PAYMENT) === $user->roles;

        };
    }

    public static function parcelExport()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->PARCEL_EXPORT) === $user->roles;

        };
    }

    public static function viewStatistics()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->VIEW_STATISTICS) === $user->roles;

        };
    }
    public static function addArticle()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->ARTICLE_ADD) === $user->roles;

        };
    }

    public static function all()
    {
        return function(User $user) {

            return ($user->roles | app('roles')->ALL) === $user->roles;

        };
    }




}
