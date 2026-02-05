#!/usr/bin/env php
<?php

/**
 * Script de Verificación: Aplicación de Permisos por Plan
 * Ubicación: /home/diego-dcr/Documentos/siscoplagas/ERP/ZONDA/control_maestro/verify_permissions.php
 * 
 * Uso:
 *   php verify_permissions.php
 *   php artisan tinker (luego paste el contenido)
 */

// Colores para terminal
class Colors {
    const RESET = "\033[0m";
    const RED = "\033[91m";
    const GREEN = "\033[92m";
    const YELLOW = "\033[93m";
    const BLUE = "\033[94m";
    const MAGENTA = "\033[95m";
    const CYAN = "\033[96m";
}

function header($text) {
    echo Colors::CYAN . "\n" . str_repeat("=", 80) . "\n";
    echo "  " . $text . "\n";
    echo str_repeat("=", 80) . Colors::RESET . "\n\n";
}

function subheader($text) {
    echo Colors::BLUE . "\n" . $text . "\n" . str_repeat("-", 40) . Colors::RESET . "\n";
}

function success($text) {
    echo Colors::GREEN . "✅ " . $text . Colors::RESET . "\n";
}

function error($text) {
    echo Colors::RED . "❌ " . $text . Colors::RESET . "\n";
}

function warning($text) {
    echo Colors::YELLOW . "⚠️  " . $text . Colors::RESET . "\n";
}

function info($text) {
    echo Colors::MAGENTA . "ℹ️  " . $text . Colors::RESET . "\n";
}

// Script principal
header("VERIFICADOR DE APLICACIÓN DE PERMISOS POR PLAN");

echo "Este script verifica que los permisos se apliquen correctamente al crear tenants.\n";
echo "Ejecute este código en: php artisan tinker\n\n";

echo Colors::YELLOW . "CÓDIGO A EJECUTAR EN TINKER:" . Colors::RESET . "\n\n";

$code = <<<'PHP'
// 1. Obtener estadísticas de planes existentes
$plans = \App\Models\Plan::all();
echo "\n📋 PLANES DISPONIBLES:\n";
foreach ($plans as $plan) {
    echo "  - Plan ID {$plan->id}: {$plan->name} ({$plan->tenants()->count()} tenants)\n";
}

// 2. Definir permisos esperados (según restrictionPermissionsPlan)
$expectedPermissions = [
    1 => [
        'show_matrix', 'handle_planning', 'handle_crm', 'handle_tracking',
        'handle_stock', 'handle_client_system'
    ],
    2 => [
        'handle_crm', 'show_matrix', 'handle_planning', 'handle_tracking',
        'handle_contracts', 'handle_stock', 'handle_rh', 'handle_client_system'
    ],
    3 => [
        'handle_crm', 'show_matrix', 'show_sedes', 'handle_tracking', 'handle_quotes',
        'handle_planning', 'handle_contracts', 'handle_control_points', 'handle_floorplans',
        'handle_quality', 'handle_report_appearance', 'show_quality_analytics',
        'handle_invoice', 'handle_client_system', 'handle_rh', 'handle_files_employees',
        'handle_stock', 'handle_product_technical_details', 'assing_technician',
        'generate_voucher_stock', 'show_stock_alerts', 'handle_customer_zones'
    ]
];

// 3. Función auxiliar para verificar tenant
function verify_tenant($tenantId, $expectedPermissions) {
    $tenant = \App\Models\Tenant::find($tenantId);
    if (!$tenant) {
        echo "  ❌ Tenant no encontrado\n";
        return false;
    }
    
    $planId = $tenant->plan_id;
    echo "\n  📌 Tenant: {$tenant->company_name}\n";
    echo "  Plan ID: {$planId}\n";
    
    // Obtener permisos permitidos
    $allowed = \App\Models\TenantPermissionControl::where('tenant_id', $tenantId)
        ->where('is_allowed', true)
        ->with('permission')
        ->get()
        ->pluck('permission.name')
        ->toArray();
    
    $denied = \App\Models\TenantPermissionControl::where('tenant_id', $tenantId)
        ->where('is_allowed', false)
        ->with('permission')
        ->get()
        ->pluck('permission.name')
        ->toArray();
    
    echo "  Permisos permitidos: " . count($allowed) . "\n";
    echo "  Permisos denegados: " . count($denied) . "\n";
    
    // Verificar si coinciden con lo esperado
    $expected = $expectedPermissions[$planId] ?? [];
    $expectedCount = count($expected);
    
    if (count($allowed) !== $expectedCount) {
        echo "  ❌ ERROR: Se esperaban {$expectedCount} permisos, pero hay " . count($allowed) . "\n";
        return false;
    }
    
    // Verificar cada permiso esperado
    $missing = array_diff($expected, $allowed);
    $extra = array_diff($allowed, $expected);
    
    if (!empty($missing)) {
        echo "  ❌ Permisos FALTANTES:\n";
        foreach ($missing as $perm) {
            echo "     - {$perm}\n";
        }
        return false;
    }
    
    if (!empty($extra)) {
        echo "  ❌ Permisos EXTRA (no deberían estar):\n";
        foreach ($extra as $perm) {
            echo "     - {$perm}\n";
        }
        return false;
    }
    
    echo "  ✅ VERIFICACIÓN EXITOSA\n";
    return true;
}

// 4. Verificar tenants existentes
echo "\n\n🔍 VERIFICANDO TENANTS EXISTENTES:\n" . str_repeat("-", 60) . "\n";
$tenants = \App\Models\Tenant::all();

if ($tenants->isEmpty()) {
    echo "No hay tenants para verificar.\n";
} else {
    $results = [];
    foreach ($tenants as $tenant) {
        $results[$tenant->id] = verify_tenant($tenant->id, $expectedPermissions);
    }
    
    $successCount = count(array_filter($results));
    $failCount = count($results) - $successCount;
    
    echo "\n\n📊 RESUMEN:\n" . str_repeat("-", 60) . "\n";
    echo "Total de tenants verificados: " . count($results) . "\n";
    echo "✅ Correctos: {$successCount}\n";
    echo "❌ Con errores: {$failCount}\n";
}

// 5. Verificar integridad de datos
echo "\n\n🔐 VERIFICACIÓN DE INTEGRIDAD:\n" . str_repeat("-", 60) . "\n";

// a) Verificar que todos los tenants tengan entradas en tenant_permission_control
$tenantsWithoutPerms = \App\Models\Tenant::whereDoesntHave('permissionControls')->get();
if ($tenantsWithoutPerms->isEmpty()) {
    echo "✅ Todos los tenants tienen entradas en tenant_permission_control\n";
} else {
    echo "❌ " . count($tenantsWithoutPerms) . " tenants NO tienen permisos configurados:\n";
    foreach ($tenantsWithoutPerms as $t) {
        echo "   - {$t->company_name} (Plan {$t->plan_id})\n";
    }
}

// b) Verificar unicidad de tenant_id + permission_id
$duplicates = \App\Models\TenantPermissionControl::selectRaw('tenant_id, permission_id, count(*) as cnt')
    ->groupBy('tenant_id', 'permission_id')
    ->having('cnt', '>', 1)
    ->count();

if ($duplicates === 0) {
    echo "✅ No hay duplicados en tenant_permission_control\n";
} else {
    echo "❌ Se encontraron {$duplicates} combinaciones duplicadas\n";
}

// c) Verificar integridad de referencias
$invalidTenants = \App\Models\TenantPermissionControl::whereDoesntHave('tenant')->count();
$invalidPerms = \App\Models\TenantPermissionControl::whereDoesntHave('permission')->count();

if ($invalidTenants === 0 && $invalidPerms === 0) {
    echo "✅ Todas las referencias son válidas (sin huérfanos)\n";
} else {
    echo "❌ Referencias inválidas encontradas:\n";
    echo "   - Tenant inválidos: {$invalidTenants}\n";
    echo "   - Permisos inválidos: {$invalidPerms}\n";
}

// 6. Información sobre planes sin configuración
echo "\n\n⚠️  ANÁLISIS DE RIESGOS:\n" . str_repeat("-", 60) . "\n";

$allPlans = \App\Models\Plan::pluck('id')->toArray();
$configuredPlans = array_keys($expectedPermissions);
$missingConfigs = array_diff($allPlans, $configuredPlans);

if (!empty($missingConfigs)) {
    echo "❌ PLANES SIN CONFIGURACIÓN DE PERMISOS:\n";
    foreach ($missingConfigs as $planId) {
        echo "   - Plan ID: {$planId}\n";
    }
    echo "\nEsto causará que los tenants con estos planes tengan TODOS los permisos denegados.\n";
} else {
    echo "✅ Todos los planes existentes tienen configuración de permisos\n";
}

echo "\n";
PHP;

echo $code;

echo "\n" . Colors::YELLOW . str_repeat("=", 80) . Colors::RESET . "\n";
echo "Para ejecutar este verificador:\n";
echo "  1. Entra a artisan tinker:\n";
echo "     cd /home/diego-dcr/Documentos/siscoplagas/ERP/ZONDA/control_maestro\n";
echo "     php artisan tinker\n\n";
echo "  2. Copia y pega el código anterior\n";
echo "  3. O ejecuta directamente:\n";
echo "     include('verify_permissions.php');\n";
echo str_repeat("=", 80) . "\n";
