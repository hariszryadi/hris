<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.frontend.main', function ($view) {
            $numberAlert = Notification::numberAlert();
            $view->with('numberAlert', $numberAlert);

            $userId = auth()->guard('user')->user()->id;
            $queryNotif = Notification::select(
                    'notifications.type_transaction',
                    'notifications.transaction_id',
                    'notifications.user_id',
                    'notifications.read',
                    'ms_empl.empl_name',
                    'ms_empl.nip',
                    'ms_empl.avatar',
                    'notifications.created_at'
                )
                ->join('users', 'notifications.user_id', '=', 'users.id')
                ->join('ms_empl', 'users.empl_id', '=', 'ms_empl.id')
                ->where('notifications.user_id', $userId)
                ->where('read', false)
                ->get();
            $view->with('queryNotif', $queryNotif);
        });
    }
}
