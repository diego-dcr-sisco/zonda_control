<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class SyncTenantPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:sync-permissions 
                            {--tenant= : ID específico del tenant a sincronizar}
                            {--all : Sincronizar todos los tenants}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los permisos de los tenants basándose en su plan asignado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->option('tenant');
        $syncAll = $this->option('all');

        if (!$tenantId && !$syncAll) {
            $this->error('Debes especificar --tenant=ID o --all');
            return 1;
        }

        if ($tenantId) {
            return $this->syncSingleTenant($tenantId);
        }

        if ($syncAll) {
            return $this->syncAllTenants();
        }

        return 0;
    }

    /**
     * Sincroniza un tenant específico
     */
    private function syncSingleTenant($tenantId)
    {
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            $this->error("Tenant con ID {$tenantId} no encontrado");
            return 1;
        }

        if (!$tenant->plan_id) {
            $this->warn("El tenant '{$tenant->company_name}' no tiene un plan asignado");
            return 1;
        }

        $this->info("Sincronizando permisos para: {$tenant->company_name}");
        $tenant->syncPermissionsFromPlan();
        $this->info("✓ Permisos sincronizados correctamente");

        // Mostrar resumen
        $permissionsCount = $tenant->permissionControls()->where('is_allowed', true)->count();
        $this->info("Total de permisos activos: {$permissionsCount}");

        return 0;
    }

    /**
     * Sincroniza todos los tenants
     */
    private function syncAllTenants()
    {
        $tenants = Tenant::whereNotNull('plan_id')->get();

        if ($tenants->isEmpty()) {
            $this->warn('No se encontraron tenants con planes asignados');
            return 0;
        }

        $this->info("Sincronizando permisos para {$tenants->count()} tenant(s)...\n");

        $bar = $this->output->createProgressBar($tenants->count());
        $bar->start();

        $synced = 0;
        $skipped = 0;

        foreach ($tenants as $tenant) {
            try {
                $tenant->syncPermissionsFromPlan();
                $synced++;
            } catch (\Exception $e) {
                $this->error("\nError al sincronizar '{$tenant->company_name}': {$e->getMessage()}");
                $skipped++;
            }
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info("✓ Sincronización completada");
        $this->table(
            ['Estado', 'Cantidad'],
            [
                ['Sincronizados', $synced],
                ['Con errores', $skipped],
            ]
        );

        return 0;
    }
}
