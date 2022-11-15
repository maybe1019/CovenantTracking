<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;

class UserDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            //
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-dashboard';
    }

   /* public static function label()
    {
        return 'User Dashboard';
    }*/
}
