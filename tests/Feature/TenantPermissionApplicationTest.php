<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Models\TenantPermissionControl;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TenantPermissionApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Permisos esperados por cada plan (según la lógica en restrictionPermissionsPlan)
     */
    protected $planPermissions = [
        1 => [
            'show_matrix',
            'handle_planning',
            'handle_crm',
            'handle_tracking',
            'handle_stock',
            'handle_client_system'
        ],
        2 => [
            'handle_crm',
            'show_matrix',
            'handle_planning',
            'handle_tracking',
            'handle_contracts',
            'handle_stock',
            'handle_rh',
            'handle_client_system'
        ],
        3 => [
            'handle_crm',
            'show_matrix',
            'show_sedes',
            'handle_tracking',
            'handle_quotes',
            'handle_planning',
            'handle_contracts',
            'handle_control_points',
            'handle_floorplans',
            'handle_quality',
            'handle_report_appearance',
            'show_quality_analytics',
            'handle_invoice',
            'handle_client_system',
            'handle_rh',
            'handle_files_employees',
            'handle_stock',
            'handle_product_technical_details',
            'assing_technician',
            'generate_voucher_stock',
            'show_stock_alerts',
            'handle_customer_zones'
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear planes
        Plan::factory()->create(['id' => 1, 'name' => 'Plan Básico']);
        Plan::factory()->create(['id' => 2, 'name' => 'Plan Profesional']);
        Plan::factory()->create(['id' => 3, 'name' => 'Plan Empresarial']);
        
        // Crear permisos para cada permiso en los planes
        $allPermissions = array_unique(
            array_merge(...array_values($this->planPermissions))
        );
        
        foreach ($allPermissions as $permissionName) {
            Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
                'category' => 't',
                'type' => 'w'
            ]);
        }
    }

    /**
     * Verifica que al crear un tenant con plan 1, los permisos se apliquen correctamente
     */
    public function test_permissions_applied_correctly_for_plan_1()
    {
        $plan = Plan::find(1);
        $tenant = Tenant::create([
            'company_name' => 'Test Company Plan 1',
            'slug' => 'test-company-plan-1',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 10,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-plan-1/',
        ]);

        // Crear relaciones en tenant_permission_control con todos los permisos inicialmente permitidos
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar que solo los permisos del plan 1 están permitidos
        $allowedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        $deniedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', false)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        // Verificar que los permisos esperados están permitidos
        foreach ($this->planPermissions[1] as $permissionName) {
            $this->assertContains(
                $permissionName,
                $allowedPermissions,
                "El permiso '$permissionName' debe estar permitido para el Plan 1"
            );
        }

        // Verificar que otros permisos estén denegados
        $otherPermissions = array_diff(
            array_merge(...array_values($this->planPermissions)),
            $this->planPermissions[1]
        );

        foreach (array_unique($otherPermissions) as $permissionName) {
            $this->assertContains(
                $permissionName,
                $deniedPermissions,
                "El permiso '$permissionName' debe estar denegado para el Plan 1"
            );
        }

        $this->assertEquals(
            count($this->planPermissions[1]),
            count($allowedPermissions),
            "El Plan 1 debe tener exactamente " . count($this->planPermissions[1]) . " permisos permitidos"
        );
    }

    /**
     * Verifica que al crear un tenant con plan 2, los permisos se apliquen correctamente
     */
    public function test_permissions_applied_correctly_for_plan_2()
    {
        $plan = Plan::find(2);
        $tenant = Tenant::create([
            'company_name' => 'Test Company Plan 2',
            'slug' => 'test-company-plan-2',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 25,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-plan-2/',
        ]);

        // Crear relaciones en tenant_permission_control con todos los permisos inicialmente permitidos
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar que solo los permisos del plan 2 están permitidos
        $allowedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        $deniedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', false)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        // Verificar que los permisos esperados están permitidos
        foreach ($this->planPermissions[2] as $permissionName) {
            $this->assertContains(
                $permissionName,
                $allowedPermissions,
                "El permiso '$permissionName' debe estar permitido para el Plan 2"
            );
        }

        // Verificar que otros permisos estén denegados
        $otherPermissions = array_diff(
            array_merge(...array_values($this->planPermissions)),
            $this->planPermissions[2]
        );

        foreach (array_unique($otherPermissions) as $permissionName) {
            $this->assertContains(
                $permissionName,
                $deniedPermissions,
                "El permiso '$permissionName' debe estar denegado para el Plan 2"
            );
        }

        $this->assertEquals(
            count($this->planPermissions[2]),
            count($allowedPermissions),
            "El Plan 2 debe tener exactamente " . count($this->planPermissions[2]) . " permisos permitidos"
        );
    }

    /**
     * Verifica que al crear un tenant con plan 3 (Empresarial), los permisos se apliquen correctamente
     */
    public function test_permissions_applied_correctly_for_plan_3()
    {
        $plan = Plan::find(3);
        $tenant = Tenant::create([
            'company_name' => 'Test Company Plan 3',
            'slug' => 'test-company-plan-3',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 100,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-plan-3/',
        ]);

        // Crear relaciones en tenant_permission_control con todos los permisos inicialmente permitidos
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar que solo los permisos del plan 3 están permitidos
        $allowedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        $deniedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', false)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        // Verificar que los permisos esperados están permitidos
        foreach ($this->planPermissions[3] as $permissionName) {
            $this->assertContains(
                $permissionName,
                $allowedPermissions,
                "El permiso '$permissionName' debe estar permitido para el Plan 3"
            );
        }

        // Verificar que otros permisos estén denegados
        $otherPermissions = array_diff(
            array_merge(...array_values($this->planPermissions)),
            $this->planPermissions[3]
        );

        foreach (array_unique($otherPermissions) as $permissionName) {
            $this->assertContains(
                $permissionName,
                $deniedPermissions,
                "El permiso '$permissionName' debe estar denegado para el Plan 3"
            );
        }

        $this->assertEquals(
            count($this->planPermissions[3]),
            count($allowedPermissions),
            "El Plan 3 debe tener exactamente " . count($this->planPermissions[3]) . " permisos permitidos"
        );
    }

    /**
     * Verifica que todos los permisos de categoría 't' sean procesados
     */
    public function test_all_tenant_category_permissions_are_processed()
    {
        $plan = Plan::find(1);
        $tenant = Tenant::create([
            'company_name' => 'Test Company All Perms',
            'slug' => 'test-company-all-perms',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 10,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-all-perms/',
        ]);

        // Crear relaciones en tenant_permission_control con todos los permisos
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar que todos los permisos de categoría 't' fueron procesados
        $totalTenantPermissions = Permission::where('category', 't')->count();
        $processedPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)->count();

        $this->assertGreaterThan(
            0,
            $totalTenantPermissions,
            "Debe haber permisos de categoría 't' disponibles"
        );

        $this->assertEquals(
            $totalTenantPermissions,
            $processedPermissions,
            "Todos los permisos de categoría 't' deben estar procesados en tenant_permission_control"
        );
    }

    /**
     * Verifica que la suma de permisos permitidos + denegados = total de permisos
     */
    public function test_allowed_plus_denied_equals_total_permissions()
    {
        $plan = Plan::find(2);
        $tenant = Tenant::create([
            'company_name' => 'Test Company Math',
            'slug' => 'test-company-math',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 25,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-math/',
        ]);

        // Crear relaciones en tenant_permission_control
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar matemáticas
        $allowed = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->count();
        
        $denied = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', false)
            ->count();
        
        $total = TenantPermissionControl::where('tenant_id', $tenant->id)->count();

        $this->assertEquals(
            $total,
            $allowed + $denied,
            "La suma de permisos permitidos y denegados debe ser igual al total"
        );
    }

    /**
     * Verifica que no haya permisos de categoría 't' duplicados por tenant
     */
    public function test_no_duplicate_permissions_per_tenant()
    {
        $plan = Plan::find(1);
        $tenant = Tenant::create([
            'company_name' => 'Test Company Duplicates',
            'slug' => 'test-company-duplicates',
            'is_active' => true,
            'plan_id' => $plan->id,
            'limit_users' => 10,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-duplicates/',
        ]);

        // Crear relaciones en tenant_permission_control
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Verificar que no haya duplicados
        $tenantPerms = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->pluck('permission_id')
            ->toArray();

        $duplicates = array_diff_assoc($tenantPerms, array_unique($tenantPerms));

        $this->assertEmpty(
            $duplicates,
            "No debe haber permisos duplicados para el tenant"
        );
    }

    /**
     * Verifica que cambiar el plan de un tenant actualice los permisos correctamente
     */
    public function test_changing_plan_updates_permissions()
    {
        $plan1 = Plan::find(1);
        $plan2 = Plan::find(2);
        
        $tenant = Tenant::create([
            'company_name' => 'Test Company Plan Change',
            'slug' => 'test-company-plan-change',
            'is_active' => true,
            'plan_id' => $plan1->id,
            'limit_users' => 10,
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'path' => 'test-company-plan-change/',
        ]);

        // Crear relaciones en tenant_permission_control
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            TenantPermissionControl::create([
                'tenant_id' => $tenant->id,
                'permission_id' => $permission->id,
                'is_allowed' => true
            ]);
        }

        // Aplicar restricciones del plan 1
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Obtener permisos después del plan 1
        $permissionsPlan1 = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        // Cambiar plan
        $tenant->update(['plan_id' => $plan2->id]);

        // Aplicar restricciones del nuevo plan
        app(\App\Http\Controllers\TenantController::class)->restrictionPermissionsPlan($tenant->id);

        // Obtener permisos después del cambio
        $permissionsPlan2 = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->toArray();

        // Verificar que los permisos son diferentes
        $this->assertNotEquals(
            $permissionsPlan1,
            $permissionsPlan2,
            "Los permisos deben cambiar cuando se cambia el plan"
        );

        // Verificar que los nuevos permisos corresponden al plan 2
        foreach ($this->planPermissions[2] as $permissionName) {
            $this->assertContains(
                $permissionName,
                $permissionsPlan2,
                "El permiso '$permissionName' debe estar permitido en el Plan 2"
            );
        }
    }
}
