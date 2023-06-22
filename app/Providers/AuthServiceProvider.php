<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //define gates
        Gate::define('admin', function ($user) {

            if(session()->get('user')->hasRole('admin') == 'admin'){
                return true;
            }
            return false;
        });
        Gate::define('super-admin', function ($user) {
            if(session()->get('user')->hasRole('super-admin') == 'super-admin'){
                return true;
            }
            return false;
        });
    }
}
