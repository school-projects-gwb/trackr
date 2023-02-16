<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Rules\StoreInAuthUser;
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

        Gate::define('validate-store-user', function ($user, $model) {
            return (new UserInStore())->passes(null, $model->id);
        });

        Gate::define('validate-store', function ($user, $model) {
            return (new StoreInAuthUser())->passes(null, $model->id);
        });
    }
}
