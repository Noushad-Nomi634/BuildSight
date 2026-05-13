<?php

namespace App\Providers;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\TeamsPermission;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
    public function boot(Router $router): void
    {
        /** @var Kernel $kernel */
        $kernel = app()->make(Kernel::class);

        $kernel->addToMiddlewarePriorityBefore(
            TeamsPermission::class,
            SubstituteBindings::class,
        );
        $router->aliasMiddleware('role', CheckRole::class);

        Blade::if('superAdmin', function () {
            return Auth::check() && Auth::user()->super_admin == 1;
        });

        Blade::if('companyAdmin', function () {

            if (!Auth::check())
                return false;

            $companyId = session('company_id');

            if (!$companyId)
                return false;

            setPermissionsTeamId($companyId);

            return Auth::user()->hasRole('company-admin');
        });

        Blade::if('role', function ($role) {

            if (!Auth::check())
                return false;

            $companyId = session('company_id');

            if ($companyId) {
                setPermissionsTeamId($companyId);
            }

            return Auth::user()->hasRole($role);
        });
    }
}
