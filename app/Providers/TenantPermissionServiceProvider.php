<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TenantPermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Cargar helpers de permisos de tenant
        if (file_exists(app_path('Helpers/tenant_permissions.php'))) {
            require_once app_path('Helpers/tenant_permissions.php');
        }
    }
}
