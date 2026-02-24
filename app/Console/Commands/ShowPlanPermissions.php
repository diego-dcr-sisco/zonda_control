<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Plan;
use App\Models\Tenant;

class ShowPlanPermissions extends Command
{
    protected $signature = 'plans:show-permissions 
                            {--plan= : Nombre del plan (Lite, Lite+, Pro)}
                            {--tenant= : ID del tenant para verificar sus permisos}';

    protected $description = 'Muestra los permisos asignados a cada plan o a un tenant específico';

    public function handle()
    {
        $planName = $this->option('plan');
        $tenantId = $this->option('tenant');

        if ($tenantId) {
            return $this->showTenantPermissions($tenantId);
        }

        if ($planName) {
            return $this->showSinglePlan($planName);
        }

        return $this->showAllPlans();
    }

    private function showAllPlans()
    {
        $plans = Plan::with('permissions')->get();

        if ($plans->isEmpty()) {
            $this->error('No se encontraron planes');
            return 1;
        }

        $this->info("═══════════════════════════════════════");
        $this->info("       PERMISOS POR PLAN");
        $this->info("═══════════════════════════════════════\n");

        foreach ($plans as $plan) {
            $permissionsCount = $plan->permissions->count();
            $this->line("📋 <fg=cyan;options=bold>{$plan->name}</>");
            $this->line("   Límite de usuarios: {$plan->limit_users}");
            $this->line("   Total de permisos: {$permissionsCount}");
            
            if ($permissionsCount > 0) {
                $this->line("\n   Permisos:");
                foreach ($plan->permissions->sortBy('name') as $permission) {
                    $this->line("      ✓ {$permission->name}");
                }
            }
            $this->newLine();
        }

        return 0;
    }

    private function showSinglePlan($planName)
    {
        $plan = Plan::where('name', 'LIKE', "%{$planName}%")
            ->with('permissions')
            ->first();

        if (ShowPlanPermissionsplan) {
            $this->error("Plan '{$planName}' no encontrado");
            return 1;
        }

        $this->info("═══════════════════════════════════════");
        $this->info("  Plan: {$plan->name}");
        $this->info("═══════════════════════════════════════\n");

        $this->table(
            ['Propiedad', 'Valor'],
            [
                ['Nombre', $plan->name],
                ['Límite de usuarios', $plan->limit_users],
                ['Total de permisos', $plan->permissions->count()],
                ['Tenants activos', $plan->tenants()->count()],
            ]
        );

        if ($plan->permissions->isNotEmpty()) {
            $this->newLine();
            $this->info('Permisos asignados:');
            
            // Agrupar por categoría
            $grouped = $plan->permissions->groupBy(function ($permission) {
                return explode('_', $permission->name)[0];
            });

            foreach ($grouped as $category => $permissions) {
                $this->line("\n<fg=yellow>{$category}</>:");
                foreach ($permissions as $permission) {
                    $this->line("  ✓ {$permission->name}");
                }
            }
        }

        return 0;
    }

    private function showTenantPermissions($tenantId)
    {
        $tenant = Tenant::with(['plan', 'permissionControls.permission'])->find($tenantId);

        if (ShowPlanPermissionstenant) {
            $this->error("Tenant con ID {$tenantId} no encontrado");
            return 1;
        }

        $this->info("═══════════════════════════════════════");
        $this->info("  Tenant: {$tenant->company_name}");
        $this->info("═══════════════════════════════════════\n");

        $this->table(
            ['Propiedad', 'Valor'],
            [
                ['Empresa', $tenant->company_name],
                ['Slug', $tenant->slug],
                ['Plan', $tenant->plan->name ?? 'Sin plan'],
                ['Activo', $tenant->is_active ? 'Sí' : 'No'],
                ['Permisos activos', $tenant->permissionControls()->where('is_allowed', true)->count()],
            ]
        );

        $allowedPermissions = $tenant->permissionControls()
            ->where('is_allowed', true)
            ->with('permission')
            ->get();

        if ($allowedPermissions->isNotEmpty()) {
            $this->newLine();
            $this->info('Permisos permitidos:');
            
            $grouped = $allowedPermissions->groupBy(function ($control) {
                return explode('_', $control->permission->name)[0];
            });

            foreach ($grouped as $category => $controls) {
                $this->line("\n<fg=yellow>{$category}</>:");
                foreach ($controls as $control) {
                    $this->line("  ✓ {$control->permission->name}");
                }
            }
        } else {
            $this->warn("\n⚠ Este tenant no tiene permisos asignados");
            $this->info("Ejecuta: php artisan tenants:sync-permissions --tenant={$tenantId}");
        }

        return 0;
    }
}
