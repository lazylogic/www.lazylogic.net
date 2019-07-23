<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern( 'pid', '[0-9]+' );
        Route::pattern( 'grade', '[a-zA-Z][a-zA-Z0-9]+' );
        Route::pattern( 'type', '[a-zA-Z][a-zA-Z0-9]+' );
        Route::pattern( 'trait', '[a-zA-Z][a-zA-Z0-9]+' );

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes( 'web', '/' );
        $this->mapWebRoutes( 'rest' );    // @created 2019.03.08  razy
        $this->mapWebRoutes( 'support' ); // @created 2019.03.08  razy
        $this->mapWebRoutes( 'admin' );   // @created 2019.03.08  razy
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @modified    2019.03.08  razy    add param   name
     * @modified    2019.03.08  razy    add param   prefix
     *
     * @return void
     */
    protected function mapWebRoutes( $name, $prefix = null )
    {
        Route::prefix( $prefix ?: $name )
            ->middleware( 'web' )
            ->namespace( $this->namespace . '\\' . ucfirst( $name ) )
            ->group( base_path( "routes/{$name}.php" ) );
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @modified    2019.03.08  razy    add namespace 'Api'
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix( 'api' )
            ->middleware( 'api' )
            ->namespace( $this->namespace . '\Api' )
            ->group( base_path( 'routes/api.php' ) );
    }
}