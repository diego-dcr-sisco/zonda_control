<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-superadmin {username : Username del usuario}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hacer que un usuario sea superAdmin en Control Maestro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        // Buscar usuario
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if (!$user) {
            $this->error("❌ Usuario '$username' no encontrado");
            
            // Mostrar usuarios disponibles
            $this->info("\n📋 Usuarios disponibles:");
            User::all()->each(function($u) {
                $this->line("   - {$u->id}: {$u->username} ({$u->email})");
            });
            
            return 1;
        }

        $this->info("✅ Usuario encontrado:");
        $this->line("   - ID: {$user->id}");
        $this->line("   - Username: {$user->username}");
        $this->line("   - Email: {$user->email}");
        $this->line("   - Name: {$user->name}");
        $this->line("   - SuperAdmin: " . ($user->is_superAdmin ? "SÍ ✓" : "NO ✗"));

        if ($user->is_superAdmin) {
            $this->info("ℹ️  El usuario ya es superAdmin");
            return 0;
        }

        // Confirmar acción
        if (!$this->confirm("\n¿Deseas hacer superAdmin al usuario '$username'?")) {
            $this->info("Cancelado");
            return 0;
        }

        // Actualizar a superAdmin
        $user->is_superAdmin = true;
        $user->save();

        $this->info("✅ Usuario actualizado a superAdmin");

        // Asignar rol AdministradorDireccion si no lo tiene
        $roles = $user->roles()->pluck('name')->toArray();
        $this->line("📋 Roles: " . (count($roles) > 0 ? implode(', ', $roles) : "NINGUNO"));

        if (!in_array('AdministradorDireccion', $roles)) {
            $user->assignRole('AdministradorDireccion');
            $this->info("✅ Rol 'AdministradorDireccion' asignado");
        }

        $this->info("\n🎉 COMPLETADO");
        $this->line("El usuario '$username' es ahora superAdmin");
        $this->line("Puede acceder a Control Maestro con todos los permisos");

        return 0;
    }
}
