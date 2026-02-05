<?php

/**
 * Script de Verificación: Permiso handle_stock en Tenants con Plan Pro
 * 
 * Este script verifica que cuando se crea un tenant con Plan Pro (Plan 2 o 3),
 * el permiso 'handle_stock' se asigna correctamente a los usuarios.
 * 
 * USO:
 * php artisan tinker
 * > include('verify_handle_stock_permission.php');
 */

use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use App\Models\TenantPermissionControl;
use Spatie\Permission\Models\Permission;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║         VERIFICACIÓN: Permiso handle_stock en Plans Pro        ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

// 1. Verificar que el permiso existe
echo "\n📋 PASO 1: Verificar que el permiso 'handle_stock' existe\n";
echo "─" . str_repeat("─", 60) . "\n";

$handleStockPerm = Permission::where('name', 'handle_stock')->first();
if ($handleStockPerm) {
    echo "✅ Permiso encontrado:\n";
    echo "   - ID: {$handleStockPerm->id}\n";
    echo "   - Nombre: {$handleStockPerm->name}\n";
    echo "   - Categoría: {$handleStockPerm->category}\n";
} else {
    echo "❌ Permiso 'handle_stock' NO existe en la tabla permissions\n";
    exit(1);
}

// 2. Obtener planes Pro (2 y 3)
echo "\n🎯 PASO 2: Obtener planes Pro (Plan 2 y 3)\n";
echo "─" . str_repeat("─", 60) . "\n";

$plansPro = Plan::whereIn('id', [2, 3])->get();
if ($plansPro->isEmpty()) {
    echo "⚠️  No hay planes con ID 2 o 3 disponibles\n";
} else {
    foreach ($plansPro as $plan) {
        echo "✅ Plan {$plan->id}: {$plan->name}\n";
    }
}

// 3. Verificar tenants con Plan Pro
echo "\n🏢 PASO 3: Tenants con Plan Pro\n";
echo "─" . str_repeat("─", 60) . "\n";

$tenantsPro = Tenant::whereIn('plan_id', [2, 3])->get();
if ($tenantsPro->isEmpty()) {
    echo "⚠️  No hay tenants configurados con Plan Pro (2 o 3)\n";
    echo "   Nota: Crea un tenant con Plan Pro para verificar\n";
} else {
    echo "Encontrados " . count($tenantsPro) . " tenant(s) con Plan Pro:\n\n";
    
    foreach ($tenantsPro as $tenant) {
        echo "┌─ Tenant: {$tenant->company_name}\n";
        echo "│  ID: {$tenant->id}\n";
        echo "│  Plan ID: {$tenant->plan_id}\n";
        echo "│  Plan Nombre: " . ($tenant->plan ? $tenant->plan->name : 'N/A') . "\n";
        
        // Verificar si tiene el permiso handle_stock
        $tenantHandleStock = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('permission_id', $handleStockPerm->id)
            ->first();
        
        if ($tenantHandleStock) {
            $status = $tenantHandleStock->is_allowed ? '✅ PERMITIDO' : '❌ DENEGADO';
            echo "│  Permiso handle_stock: {$status}\n";
        } else {
            echo "│  Permiso handle_stock: ⚠️  NO CONFIGURADO\n";
        }
        
        // Obtener usuarios del tenant
        $users = User::where('tenant_id', $tenant->id)->get();
        echo "│  Usuarios: " . count($users) . "\n";
        
        foreach ($users as $user) {
            echo "│    └─ {$user->name} ({$user->email})\n";
        }
        
        echo "└─ " . str_repeat("─", 55) . "\n";
    }
}

// 4. Comparación: Configuración esperada vs realidad
echo "\n⚖️  PASO 4: Comparación - Configuración esperada vs realidad\n";
echo "─" . str_repeat("─", 60) . "\n";

$expectedConfig = [
    1 => ['show_matrix', 'handle_planning', 'handle_crm', 'handle_tracking', 'handle_stock', 'handle_client_system'],
    2 => ['handle_crm', 'show_matrix', 'handle_planning', 'handle_tracking', 'handle_contracts', 'handle_stock', 'handle_rh', 'handle_client_system'],
    3 => ['handle_crm', 'show_matrix', 'show_sedes', 'handle_tracking', 'handle_quotes', 'handle_planning', 'handle_contracts', 'handle_control_points', 'handle_floorplans', 'handle_quality', 'handle_report_appearance', 'show_quality_analytics', 'handle_invoice', 'handle_client_system', 'handle_rh', 'handle_files_employees', 'handle_stock', 'handle_product_technical_details', 'assing_technician', 'generate_voucher_stock', 'show_stock_alerts', 'handle_customer_zones']
];

foreach ([2, 3] as $planId) {
    echo "\nPlan {$planId}:\n";
    $hasHandleStock = in_array('handle_stock', $expectedConfig[$planId]);
    echo "   handle_stock en configuración: " . ($hasHandleStock ? '✅ SÍ' : '❌ NO') . "\n";
}

// 5. Resumen
echo "\n📊 RESUMEN DE VERIFICACIÓN\n";
echo "─" . str_repeat("─", 60) . "\n";

$allOk = true;
if (!$handleStockPerm) {
    echo "❌ El permiso handle_stock no existe\n";
    $allOk = false;
}

foreach ($tenantsPro as $tenant) {
    $tenantHandleStock = TenantPermissionControl::where('tenant_id', $tenant->id)
        ->where('permission_id', $handleStockPerm->id)
        ->first();
    
    if (!$tenantHandleStock) {
        echo "❌ Tenant '{$tenant->company_name}' no tiene configurado handle_stock\n";
        $allOk = false;
    } elseif (!$tenantHandleStock->is_allowed) {
        echo "❌ Tenant '{$tenant->company_name}' tiene handle_stock pero está denegado\n";
        $allOk = false;
    }
}

if ($allOk && !$tenantsPro->isEmpty()) {
    echo "✅ Todos los tenants Pro tienen handle_stock correctamente configurado\n";
} elseif ($tenantsPro->isEmpty()) {
    echo "⚠️  No hay tenants Pro para verificar. Crea uno primero.\n";
}

echo "\n" . str_repeat("─", 62) . "\n\n";
