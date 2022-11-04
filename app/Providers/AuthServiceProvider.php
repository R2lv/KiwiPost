<?php

namespace App\Providers;

use App\Order;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('order.create', OrderPolicy::create());

        Gate::define('see', OrderPolicy::show());

        Gate::define('PARCEL_ADD', UserPolicy::parcelAdd());
        Gate::define('PARCEL_DELETE', UserPolicy::parcelDelete());
        Gate::define('PARCEL_VIEW_ALL', UserPolicy::parcelViewAll());
        Gate::define('PARCEL_CHANGE_STATUS', UserPolicy::parcelChangeStatus());
        Gate::define('PARCEL_MAKE_PAYMENT', UserPolicy::parcelMakePayment());
        Gate::define('PARCEL_EXPORT', UserPolicy::parcelExport());
        Gate::define('VIEW_STATISTICS', UserPolicy::viewStatistics());
        Gate::define('ALL', UserPolicy::all());
        Gate::define('ARTICLE_ADD', UserPolicy::addArticle());
        Gate::define('SEE_USERS', UserPolicy::seeUsers());


        // inserts roles to app
        app()->singleton("roles", function() {
            return (object)config('defaults.roles');
        });


        //
    }
}
