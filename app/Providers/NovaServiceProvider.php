<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\User;
use Axistrustee\Compliance\Compliance;
use Axis\Newcompliance\Newcompliance;
use Acme\Calendar\Calendar;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    /*public function boot()
    {
        parent::boot();
    }*/

    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render('
                <div style="text-align:center;bottom:0;">Powered By <span style="color:#97144c;">Axis Trustee</span></div>
            ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            //new \App\Nova\Dashboards\Main,
            //new \App\Nova\Dashboards\UserDashboard,
            (new \App\Nova\Dashboards\UserDashboard)->canSee(function ($request) {
                //return $request->user()->can('viewUserInsights', User::class);
                return $request->user()->role_id != 1;
            }),
            (new \App\Nova\Dashboards\Main)->canSee(function ($request) {
                //return $request->user()->can('viewUserInsights', User::class);
                return $request->user()->role_id == 1;
            }),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Bolechen\NovaActivitylog\NovaActivitylog(),
            new Compliance,
            new Newcompliance,
            new Calendar,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
