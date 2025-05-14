<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('task_show',function ($user,$task){
            return $user->id == $task->user_id ;
        });
        Gate::define('is_Admin',function ($user){
            return $user->is_admin == 1 ;
        });

        Gate::before(function ($user ,$ability) { // called before calling the  method above
            if ($user->is_admin && in_array($ability, ['task_show','task_update','task_delete'])) {
                return true;
            }
        });
    }
}
