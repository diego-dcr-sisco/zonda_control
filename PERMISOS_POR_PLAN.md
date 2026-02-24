# Sistema de Permisos por Plan

Este sistema gestiona permisos para tenants basándose en su plan asignado (Lite, Lite+, Pro).

## Estructura

### Tablas

1. **plans** - Almacena los planes disponibles
2. **plan_permissions** - Tabla pivot que relaciona planes con permisos
3. **tenant_permission_control** - Controla qué permisos tiene cada tenant
4. **permissions** - Todos los permisos disponibles (Spatie)

### Modelos Actualizados

- **Plan**: Incluye relación `permissions()`
- **Tenant**: Incluye métodos:
  - `syncPermissionsFromPlan()` - Sincroniza permisos según el plan
  - `getAllowedPermissions()` - Obtiene permisos permitidos
  - `hasPermission($name)` - Verifica si tiene un permiso específico

## Permisos por Plan

### Lite (11 permisos)
- create_orders
- create_pests
- create_products
- create_services
- create_client_users
- handle_customers
- handle_services
- handle_products
- handle_pests
- handle_orders
- show_crm

### Lite+ (27 permisos)
- create_customers
- create_leads
- create_orders
- create_lots
- create_pests
- create_products
- create_quotes
- create_services
- create_trackings
- create_client_users
- consult_reports
- config_report_appearance
- handle_users
- handle_customers
- handle_branches
- handle_comercial_zones
- handle_services
- handle_products
- handle_pests
- handle_orders
- handle_contracts
- handle_leads
- handle_quotes
- show_client_system
- show_crm
- show_planning
- show_quality_control
- show_sedes

### Pro (43 permisos) - Todos los permisos
- create_branches
- create_contracts
- create_cpoints
- create_customers
- create_floorplans
- create_lots
- create_orders
- create_pests
- create_products
- create_quotes
- create_services
- create_stocks
- create_trackings
- create_admin_users
- create_client_users
- create_leads
- consult_reports
- consult_dirs
- config_report_appearance
- handle_drive_files
- handle_users
- handle_customers
- handle_branches
- handle_comercial_zones
- handle_services
- handle_products
- handle_pests
- handle_orders
- handle_contracts
- handle_control_points
- handle_leads
- handle_quotes
- show_client_system
- show_crm
- show_planning
- show_quality_control
- show_rh
- show_sedes
- show_stocks
- show_invoices

## Instalación

### 1. Ejecutar las migraciones

```bash
php artisan migrate
```

Esto creará la tabla `plan_permissions`.

### 2. Ejecutar los seeders

```bash
php artisan db:seed
```

Esto ejecutará en orden:
1. SuperAdminSeeder
2. PlanSeeder (Lite, Lite+, Pro)
3. TenantPermissionSeeder (todos los permisos)
4. PlanPermissionMappingSeeder (asocia permisos a planes)

## Uso

### Ver permisos de planes y tenants

#### Ver todos los planes y sus permisos
```bash
php artisan plans:show-permissions
```

#### Ver permisos de un plan específico
```bash
php artisan plans:show-permissions --plan=Lite
php artisan plans:show-permissions --plan="Lite+"
php artisan plans:show-permissions --plan=Pro
```

#### Ver permisos de un tenant específico
```bash
php artisan plans:show-permissions --tenant=1
```

### Sincronizar permisos de tenants

#### Sincronizar un tenant específico
```bash
php artisan tenants:sync-permissions --tenant=1
```

#### Sincronizar todos los tenants
```bash
php artisan tenants:sync-permissions --all
```

### Uso en código

#### Sincronizar permisos de un tenant
```php
$tenant = Tenant::find(1);
$tenant->syncPermissionsFromPlan();
```

#### Verificar si un tenant tiene un permiso
```php
if ($tenant->hasPermission('create_orders')) {
    // El tenant puede crear órdenes
}
```

#### Obtener todos los permisos de un tenant
```php
$permissions = $tenant->getAllowedPermissions();
```

#### Obtener permisos de un plan
```php
$plan = Plan::find(1);
$permissions = $plan->permissions;
```

## Usuario ddcr (Super Admin)

El usuario `ddcr` no tiene tenant asociado y debe tener todos los permisos del plan Pro asignados directamente como super admin en el SuperAdminSeeder.

## Proceso de creación de tenant

Cuando crees un nuevo tenant:

1. Asigna un plan al tenant:
```php
$tenant = Tenant::create([
    'company_name' => 'Mi Empresa',
    'slug' => 'mi-empresa',
    'plan_id' => 2, // Lite+
    // ... otros campos
]);
```

2. Sincroniza los permisos automáticamente:
```php
$tenant->syncPermissionsFromPlan();
```

## Cambio de plan

Si un tenant cambia de plan:

```php
$tenant->plan_id = 3; // Cambiar a Pro
$tenant->save();
$tenant->syncPermissionsFromPlan(); // Actualizar permisos
```

## Archivos modificados/creados

### Creados:
- `database/migrations/2026_02_21_090701_create_plan_permissions_table.php`
- `database/seeders/PlanPermissionMappingSeeder.php`
- `app/Console/Commands/SyncTenantPermissions.php`

### Modificados:
- `database/seeders/TenantPermissionSeeder.php` - Todos los permisos agregados
- `database/seeders/DatabaseSeeder.php` - Orden de seeders
- `app/Models/Plan.php` - Relación con permisos
- `app/Models/Tenant.php` - Métodos para gestionar permisos

## Notas importantes

1. Los permisos son controlados por la tabla `tenant_permission_control`
2. Un tenant solo puede tener los permisos definidos en su plan
3. El super admin (ddcr) no está sujeto a estas restricciones
4. Los permisos se pueden desactivar individualmente cambiando `is_allowed` a `false` en `tenant_permission_control`
