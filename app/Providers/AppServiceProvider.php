<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


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
        Gate::define('admin',function($user){
            return $user->role == 'admin';
        });

        Gate::define('pengurus',function($user){
            return $user->role == 'pengurus';
        });
        Gate::define('anggota',function($user){
            return $user->role == 'anggota';
        });
    }
}
