<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Rules\StoreInUser;
use App\Rules\StoreOwnedByAuthUser;
use App\Rules\UserInStore;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('user-in-store', function ($user, $model) {
            return (new UserInStore())->passes(null, $model->id);
        });

        Gate::define('store-in-user', function ($store, $model) {
            return (new StoreInUser())->passes(null, $model->id);
        });

        Gate::define('store-in-auth-user', function ($user, $model) {
            return (new StoreOwnedByAuthUser())->passes(null, $model->id);
        });
    }
}
