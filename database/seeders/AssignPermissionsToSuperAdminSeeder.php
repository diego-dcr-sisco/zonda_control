<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToSuperAdminSeeder extends Seeder
{
    /**
     * The Artisan command instance.
     *
     * @var \Illuminate\Console\Command|null
     */
    protected $command;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el super admin (usuario sin tenant)
        $superAdmins = User::where('is_superAdmin', true)
            ->whereNull('tenant_id')
            ->get();

        if ($superAdmins->isEmpty()) {
            $this->command->warn('No se encontraron usuarios super admin sin tenant');
            return;
        }

        // Obtener todos los permisos de categoría tenant
        $permissions = Permission::where('category', 't')->get();

        if ($permissions->isEmpty()) {
            $this->command->warn('No se encontraron permisos de categoría tenant');
            return;
        }

        $permissionNames = $permissions->pluck('name')->toArray();

        foreach ($superAdmins as $superAdmin) {
            // Asignar todos los permisos
            $superAdmin->givePermissionTo($permissionNames);
            
            $this->command->info("✓ Asignados {$permissions->count()} permisos a: {$superAdmin->name} ({$superAdmin->username})");
        }

        $this->command->info('Permisos asignados exitosamente a todos los super admins');

        // Si existe el usuario ddcr específicamente, asegurarnos que tenga todos los permisos
        $ddcr = User::where('username', 'ddcr')
            ->orWhere('email', 'ddcr@mail.com')
            ->first();

        if ($ddcr) {
            $ddcr->givePermissionTo($permissionNames);
            $this->command->info("✓ Permisos asignados al usuario ddcr");
        }
    }
}
