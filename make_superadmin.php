#!/usr/bin/env php
<?php

/**
 * Script para hacer un usuario superAdmin en Control Maestro
 * 
 * Uso:
 *   php artisan tinker
 *   include('make_superadmin.php');
 * 
 * O:
 *   php make_superadmin.php (ejecutable directo)
 */

// Si se ejecuta directo desde línea de comando
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($argv[0] ?? '')) {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
}

use App\Models\User;

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║         HACER USUARIO SUPERADMIN EN CONTROL MAESTRO       ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Buscar usuario ddcr
$user = User::where('username', 'ddcr')->orWhere('email', 'ddcr@mail.com')->first();

if (!$user) {
    echo "❌ Usuario 'ddcr' no encontrado\n";
    echo "\n📝 Usuarios existentes:\n";
    $users = User::pluck('username', 'id');
    foreach ($users as $id => $username) {
        echo "   - ID: $id | Username: $username\n";
    }
    return false;
}

echo "✅ Usuario encontrado:\n";
echo "   - ID: {$user->id}\n";
echo "   - Username: {$user->username}\n";
echo "   - Email: {$user->email}\n";
echo "   - Name: {$user->name}\n";
echo "   - SuperAdmin actual: " . ($user->is_superAdmin ? "SÍ" : "NO") . "\n\n";

if ($user->is_superAdmin) {
    echo "ℹ️  El usuario ya es superAdmin\n";
    return true;
}

// Actualizar a superAdmin
$user->is_superAdmin = true;
$user->save();

echo "✅ Usuario actualizado a superAdmin\n\n";

// Verificar rol
$roles = $user->roles()->pluck('name')->toArray();
echo "📋 Roles actuales: " . (count($roles) > 0 ? implode(', ', $roles) : 'NINGUNO') . "\n\n";

// Asignar rol si no lo tiene
if (!in_array('AdministradorDireccion', $roles)) {
    $user->assignRole('AdministradorDireccion');
    echo "✅ Rol 'AdministradorDireccion' asignado\n\n";
}

echo "🎉 COMPLETADO\n";
echo "El usuario 'ddcr' es ahora superAdmin\n";
echo "Puede acceder a Control Maestro con todos los permisos\n\n";

return true;
