<?php
// Script para verificar handle_stock en Plans Pro
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Tenant;
use App\Models\Plan;
use App\Models\TenantPermissionControl;
use Spatie\Permission\Models\Permission;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║    VERIFICACIÓN: Permiso 'handle_stock' en Plans Pro (2 y 3)   ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

// Verificar que el permiso existe
$handleStockPerm = Permission::where('name', 'handle_stock')->first();
echo "\n1. Permiso handle_stock:\n";
if ($handleStockPerm) {
    echo "   ✅ Existe (ID: {$handleStockPerm->id})\n";
} else {
    echo "   ❌ NO EXISTE\n";
    exit(1);
}

// Obtener planes
$plans = Plan::all();
echo "\n2. Planes disponibles:\n";
foreach ($plans as $plan) {
    echo "   - Plan {$plan->id}: {$plan->name}\n";
}

// Verificar tenants con Plan Pro
$tenantsPro = Tenant::whereIn('plan_id', [2, 3])->with('plan')->get();
echo "\n3. Tenants con Plan Pro (2 o 3):\n";

if ($tenantsPro->isEmpty()) {
    echo "   ⚠️  NO HAY TENANTS CON PLAN PRO CREADOS\n";
} else {
    foreach ($tenantsPro as $tenant) {
        echo "\n   ┌─ {$tenant->company_name} (Tenant ID: {$tenant->id})\n";
        echo "   │  Plan: {$tenant->plan->name} (ID: {$tenant->plan_id})\n";
        
        // Verificar permiso
        $tenantPerm = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->where('permission_id', $handleStockPerm->id)
            ->first();
        
        if ($tenantPerm) {
            $status = $tenantPerm->is_allowed ? '✅ PERMITIDO' : '❌ DENEGADO';
            echo "   │  handle_stock: {$status}\n";
        } else {
            echo "   │  handle_stock: ⚠️  NO CONFIGURADO\n";
        }
        echo "   └─\n";
    }
}

// Mostrar configuración esperada
echo "\n4. Configuración esperada en restrictionPermissionsPlan():\n";
$expectedConfig = [
    2 => ['handle_crm', 'show_matrix', 'handle_planning', 'handle_tracking', 'handle_contracts', 'handle_stock', 'handle_rh', 'handle_client_system'],
    3 => ['handle_crm', 'show_matrix', 'show_sedes', 'handle_tracking', 'handle_quotes', 'handle_planning', 'handle_contracts', 'handle_control_points', 'handle_floorplans', 'handle_quality', 'handle_report_appearance', 'show_quality_analytics', 'handle_invoice', 'handle_client_system', 'handle_rh', 'handle_files_employees', 'handle_stock', 'handle_product_technical_details', 'assing_technician', 'generate_voucher_stock', 'show_stock_alerts', 'handle_customer_zones']
];

foreach ([2, 3] as $planId) {
    $hasHandleStock = in_array('handle_stock', $expectedConfig[$planId]);
    echo "   Plan $planId: handle_stock " . ($hasHandleStock ? '✅ INCLUIDO' : '❌ NO INCLUIDO') . "\n";
}

// Resumen
echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                         RESUMEN                                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

$allCorrect = true;
foreach ($tenantsPro as $tenant) {
    $tenantPerm = TenantPermissionControl::where('tenant_id', $tenant->id)
        ->where('permission_id', $handleStockPerm->id)
        ->first();
    
    if (!$tenantPerm || !$tenantPerm->is_allowed) {
        $allCorrect = false;
        break;
    }
}

if ($tenantsPro->isEmpty()) {
    echo "ℹ️  No hay tenants Pro para verificar.\n";
    echo "    Crea un tenant con Plan Pro (2 o 3) para validar.\n";
} elseif ($allCorrect) {
    echo "✅ CORRECTO: Todos los tenants Pro tienen handle_stock permitido.\n";
} else {
    echo "❌ ERROR: Algunos tenants Pro no tienen handle_stock configurado correctamente.\n";
}

echo "\n";
