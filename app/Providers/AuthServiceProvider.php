<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Estas rutas permiten a Passport hacer issue y revoke de access tokens y clients.
        /** @var CachesRoutes $app */
        $app = $this->app;
        if (!$app->routesAreCached()) {
            Passport::routes();
        }

        Passport::tokensExpireIn(now()->addDays(10));

        Passport::refreshTokensExpireIn(now()->addDays(10));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Passport::tokensCan([
            'api' => 'User Type',
            'api_sice' => 'sice User type',
            'view-user' => 'Ver Informacion Del Usuario',
        ]);

        \Illuminate\Support\Facades\Auth::provider('customuserprovider', function ($app, array $config) {
            return new AuthValidateStatusServiceProvider($app['hash'], $config['model']);
        });
    }
}
