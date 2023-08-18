<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admins;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


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
        View::composer('layouts.topnav', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $admin = Admins::where('username', $user->username)->get();
                $credit=$admin[0]->credit;
                $view->with('credit', $credit)->with('permission', $user->permission);
            }
            else
            {$view->with('credit', '0')->with('permission', 'reseller');}
        });
    }
}
