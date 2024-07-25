<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('dashboard.*', function ($view)
        {
            $notifications = Notification::query()
                ->where('user_id', Auth::user()->id ?? null)
                ->get();

            //...with this variable
            $view->with('notifications', $notifications );
        });

//        $notifications = Notification::query()
//            ->where('user_id', Auth::user()->id)
//            ->get();
//
//        View::share('notifications', $notifications);

        Paginator::useBootstrap();
    }
}
