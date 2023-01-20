<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives for Role Check
        Blade::directive('role', function ($role) {
             return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) :?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
             return "<?php endif; ?>"; //return this endif statement inside php tag
        });

        Blade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->can({$permission})) : ?>"; //return this if statement inside php tag
       });

       Blade::directive('endpermission', function ($permission) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
       });


    }
}
