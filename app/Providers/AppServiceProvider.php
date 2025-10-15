<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pengguna;
use Illuminate\Support\Facades\View;

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
        // Bagikan data pengguna yang sedang login ke semua view
        View::composer('*', function ($view) {
            if (session()->has('user_id')) {
                $user = Pengguna::find(session('user_id'));
                $view->with('authUser', $user);
            } else {
                $view->with('authUser', null);
            }
        });
    }
}
