# Ejemplos Prácticos - Sistema de Permisos por Plan

## Escenarios Comunes

### 1. Crear un nuevo tenant con plan Lite

```php
use App\Models\Tenant;

// Crear el tenant
$tenant = Tenant::create([
    'company_name' => 'Fumigaciones ABC',
    'slug' => 'fumigaciones-abc',
    'plan_id' => 1, // Lite
    'is_active' => true,
    'subscription_start' => now(),
    'subscription_end' => now()->addYear(),
    'path' => '/path/to/tenant',
]);

// Sincronizar permisos según el plan
$tenant->syncPermissionsFromPlan();

// Verificar permisos asignados
$permissions = $tenant->getAllowedPermissions();
echo "Permisos asignados: " . $permissions->count(); // 11 permisos
```

### 2. Actualizar tenant de Lite a Pro

```php
use App\Models\Tenant;

$tenant = Tenant::find(1);

// Cambiar el plan
$tenant->plan_id = 3; // Pro
$tenant->save();

// Sincronizar nuevos permisos
$tenant->syncPermissionsFromPlan();

// Ahora el tenant tendrá 43 permisos en lugar de 11
```

### 3. Verificar permisos antes de ejecutar una acción

```php
use App\Models\Tenant;

$tenant = Tenant::find(1);

// Verificar si puede crear órdenes
if ($tenant->hasPermission('create_orders')) {
    // Permitir crear orden
    echo "✓ Puede crear órdenes";
} else {
    // Denegar acción
    echo "✗ No tiene permiso para crear órdenes";
}

// Verificar múltiples permisos
$requiredPermissions = ['create_orders', 'handle_customers', 'show_crm'];
$hasAllPermissions = true;

foreach ($requiredPermissions as $permission) {
    if (!$tenant->hasPermission($permission)) {
        $hasAllPermissions = false;
        break;
    }
}

if ($hasAllPermissions) {
    echo "✓ Tiene todos los permisos necesarios";
}
```

### 4. Middleware para verificar permisos de tenant

```php
// app/Http/Middleware/CheckTenantPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;

class CheckTenantPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();
        
        // Super admins pasan siempre
        if ($user->is_superAdmin) {
            return $next($request);
        }
        
        // Verificar si el usuario tiene tenant
        if (!$user->tenant_id) {
            abort(403, 'Usuario sin tenant asignado');
        }
        
        $tenant = Tenant::find($user->tenant_id);
        
        // Verificar permiso
        if (!$tenant->hasPermission($permission)) {
            abort(403, "No tienes permiso para: {$permission}");
        }
        
        return $next($request);
    }
}

// Uso en rutas:
Route::middleware(['auth', 'check.tenant.permission:create_orders'])
    ->post('/orders', [OrderController::class, 'store']);
```

### 5. Controller con verificación de permisos

```php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Order;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();
        
        // Usuario super admin puede todo
        if ($user->is_superAdmin) {
            return view('orders.create');
        }
        
        // Verificar permisos del tenant
        $tenant = Tenant::find($user->tenant_id);
        
        if (!$tenant) {
            return redirect()->back()->with('error', 'Tenant no encontrado');
        }
        
        if (!$tenant->hasPermission('create_orders')) {
            return redirect()->back()->with('error', 'Tu plan no permite crear órdenes');
        }
        
        return view('orders.create');
    }
    
    public function store(Request $request)
    {
        $user = $request->user();
        $tenant = Tenant::find($user->tenant_id);
        
        // Verificar permisos
        if (!$user->is_superAdmin && !$tenant->hasPermission('create_orders')) {
            return response()->json(['error' => 'Sin permisos'], 403);
        }
        
        // Crear la orden
        $order = Order::create($request->validated());
        
        return response()->json(['success' => true, 'order' => $order]);
    }
}
```

### 6. Blade: Mostrar opciones según permisos

```blade
{{-- resources/views/dashboard.blade.php --}}

@php
    $user = auth()->user();
    $tenant = $user->tenant_id ? App\Models\Tenant::find($user->tenant_id) : null;
    $isSuperAdmin = $user->is_superAdmin;
@endphp

<div class="menu">
    {{-- Órdenes - disponible en todos los planes --}}
    @if($isSuperAdmin || ($tenant && $tenant->hasPermission('create_orders')))
        <a href="{{ route('orders.create') }}">
            <i class="icon-order"></i> Crear Orden
        </a>
    @endif
    
    {{-- Clientes - solo Lite+ y Pro --}}
    @if($isSuperAdmin || ($tenant && $tenant->hasPermission('create_customers')))
        <a href="{{ route('customers.create') }}">
            <i class="icon-customer"></i> Crear Cliente
        </a>
    @endif
    
    {{-- Stocks - solo Pro --}}
    @if($isSuperAdmin || ($tenant && $tenant->hasPermission('create_stocks')))
        <a href="{{ route('stocks.create') }}">
            <i class="icon-stock"></i> Gestionar Stock
        </a>
    @endif
    
    {{-- Reportes - Lite+ y Pro --}}
    @if($isSuperAdmin || ($tenant && $tenant->hasPermission('consult_reports')))
        <a href="{{ route('reports.index') }}">
            <i class="icon-report"></i> Reportes
        </a>
    @endif
</div>

{{-- Mensaje de limitación de plan --}}
@if(!$isSuperAdmin && $tenant && $tenant->plan->name === 'Lite')
    <div class="alert alert-info">
        <strong>Plan Lite:</strong> 
        Actualiza a Lite+ o Pro para acceder a más funcionalidades.
        <a href="{{ route('plans.upgrade') }}">Ver planes</a>
    </div>
@endif
```

### 7. API: Verificar permisos en respuestas

```php
// app/Http/Controllers/Api/PermissionsController.php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Tenant;

class PermissionsController extends Controller
{
    /**
     * Obtener permisos del tenant actual
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->is_superAdmin) {
            // Super admin tiene todos los permisos
            return response()->json([
                'is_super_admin' => true,
                'permissions' => 'all',
                'plan' => 'unlimited'
            ]);
        }
        
        $tenant = Tenant::find($user->tenant_id);
        
        if (!$tenant) {
            return response()->json(['error' => 'Tenant no encontrado'], 404);
        }
        
        $permissions = $tenant->getAllowedPermissions();
        
        return response()->json([
            'is_super_admin' => false,
            'plan' => $tenant->plan->name,
            'permissions' => $permissions->pluck('name'),
            'permissions_count' => $permissions->count()
        ]);
    }
    
    /**
     * Verificar un permiso específico
     */
    public function check(Request $request, string $permission)
    {
        $user = $request->user();
        
        if ($user->is_superAdmin) {
            return response()->json(['has_permission' => true]);
        }
        
        $tenant = Tenant::find($user->tenant_id);
        
        return response()->json([
            'has_permission' => $tenant ? $tenant->hasPermission($permission) : false
        ]);
    }
}

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/permissions', [PermissionsController::class, 'index']);
    Route::get('/permissions/check/{permission}', [PermissionsController::class, 'check']);
});
```

### 8. Comando personalizado para auditar permisos

```bash
# Ver todos los planes
php artisan plans:show-permissions

# Ver permisos del plan Lite+
php artisan plans:show-permissions --plan="Lite+"

# Ver permisos de un tenant específico
php artisan plans:show-permissions --tenant=5

# Sincronizar permisos de un tenant
php artisan tenants:sync-permissions --tenant=5

# Sincronizar todos los tenants
php artisan tenants:sync-permissions --all
```

### 9. Test unitario para permisos

```php
// tests/Unit/TenantPermissionsTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantPermissionsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_tenant_lite_has_correct_permissions()
    {
        $plan = Plan::where('name', 'Lite')->first();
        $tenant = Tenant::factory()->create(['plan_id' => $plan->id]);
        
        $tenant->syncPermissionsFromPlan();
        
        $this->assertTrue($tenant->hasPermission('create_orders'));
        $this->assertTrue($tenant->hasPermission('show_crm'));
        $this->assertFalse($tenant->hasPermission('create_stocks'));
    }
    
    public function test_tenant_upgrade_gets_new_permissions()
    {
        $litePlan = Plan::where('name', 'Lite')->first();
        $proPlan = Plan::where('name', 'Pro')->first();
        
        $tenant = Tenant::factory()->create(['plan_id' => $litePlan->id]);
        $tenant->syncPermissionsFromPlan();
        
        // Verificar que no tiene permisos de Pro
        $this->assertFalse($tenant->hasPermission('create_stocks'));
        
        // Actualizar a Pro
        $tenant->plan_id = $proPlan->id;
        $tenant->save();
        $tenant->syncPermissionsFromPlan();
        
        // Verificar que ahora tiene permisos de Pro
        $this->assertTrue($tenant->hasPermission('create_stocks'));
    }
}
```

### 10. Consola: Operaciones comunes

```bash
# Ver estructura de la base de datos
php artisan schema:show --table=plan_permissions

# Crear un tenant desde consola
php artisan tinker
>>> $tenant = Tenant::create(['company_name' => 'Test', 'slug' => 'test', 'plan_id' => 2]);
>>> $tenant->syncPermissionsFromPlan();
>>> $tenant->getAllowedPermissions()->pluck('name');

# Verificar permisos de un tenant
php artisan tinker
>>> $tenant = Tenant::find(1);
>>> $tenant->hasPermission('create_orders');
>>> $tenant->getAllowedPermissions()->count();

# Ver permisos de un plan
php artisan tinker
>>> $plan = Plan::find(2); // Lite+
>>> $plan->permissions->pluck('name');
```

## Flujo Completo de Trabajo

### Nuevo Cliente
1. **Administrador crea tenant**
   ```bash
   php artisan tinker
   >>> $tenant = Tenant::create([...]);
   >>> $tenant->syncPermissionsFromPlan();
   ```

2. **Usuarios del tenant acceden según permisos**
   - Middleware verifica permisos
   - Vista muestra opciones disponibles
   - API retorna permisos actuales

3. **Cliente solicita upgrade**
   ```php
   $tenant->plan_id = 3; // Pro
   $tenant->save();
   $tenant->syncPermissionsFromPlan();
   ```

4. **Monitoreo**
   ```bash
   php artisan plans:show-permissions --tenant=1
   ```
