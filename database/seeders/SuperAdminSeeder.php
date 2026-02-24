<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $superAdmin = User::create([
            'is_superAdmin' => true,
            'name' => 'Super Administrador',
            'nickname' => '@superAdmin',
            'username' => 'superadmin',
            'email' => 'superAdmin@mail.com',
            'password' => Hash::make('@superAdmin'),
            'role_id' => 4,
            'type_id' => 1,
        ]);

        // Asignar solo el rol
        $superAdmin->assignRole('AdministradorDireccion');

        // Asignar todos los permisos de categoría tenant al super admin
        $this->assignAllTenantPermissionsToSuperAdmin($superAdmin);
    }

    /**
     * Asignar todos los permisos de tenant al super admin
     */
    private function assignAllTenantPermissionsToSuperAdmin(User $user): void
    {
        // Esperar a que los permisos existan (se crearán en TenantPermissionSeeder)
        // Este método se puede llamar después si es necesario
        try {
            $permissions = Permission::where('category', 't')->get();
            if ($permissions->isNotEmpty()) {
                $user->givePermissionTo($permissions->pluck('name')->toArray());
                $this->command->info("✓ Asignados {$permissions->count()} permisos al super admin");
            }
        } catch (\Exception $e) {
            // Los permisos aún no existen, se asignarán después
            $this->command->warn("⚠ Los permisos de tenant se asignarán en el siguiente seeder");
        }
    }
}
