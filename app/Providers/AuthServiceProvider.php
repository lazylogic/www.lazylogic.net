<?php

namespace App\Providers;

use App\Extensions\CISession\Auth\CISessionGuard;
use App\Extensions\CISession\Auth\CISessionUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider( 'ciuser', function ( $app, array $config ) {
            return new CISessionUserProvider( $app, $config['model'] );
        } );

        Auth::extend( 'cisession', function ( $app, $name, array $config ) {
            return new CISessionGuard( $name, Auth::createUserProvider( $config['provider'] ), $app->make( 'request' ) );
        } );
    }
}