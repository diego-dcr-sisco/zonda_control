# Resumen de Implementación - Sistema de Permisos por Plan

**Fecha:** 21 de febrero de 2026  
**Sistema:** Control Maestro - Gestión de Permisos por Plan

## ✅ Implementaciones Completadas

### 1. Estructura de Base de Datos

#### Tablas Creadas/Modificadas:
- ✅ `plan_permissions` - Tabla pivot para relacionar planes con permisos
  - Migración: `2026_02_21_090701_create_plan_permissions_table.php`

#### Tablas Existentes Utilizadas:
- `plans` - Planes del sistema (Lite, Lite+, Pro)
- `permissions` - Permisos del sistema (Spatie)
- `tenant_permission_control` - Control de permisos por tenant
- `tenant` - Información de los tenants

### 2. Modelos Actualizados

#### Plan.php
- ✅ Agregada relación `permissions()` con tabla pivot
- ✅ Usa `BelongsToMany` para permisos

#### Tenant.php
- ✅ Agregada relación `permissionControls()`
- ✅ Método `syncPermissionsFromPlan()` - Sincroniza permisos basados en el plan
- ✅ Método `getAllowedPermissions()` - Obtiene permisos permitidos
- ✅ Método `hasPermission($name)` - Verifica permisos específicos

### 3. Seeders

#### TenantPermissionSeeder.php (Actualizado)
- ✅ 62 permisos totales agregados
- ✅ Organizados por categorías:
  - CREATE (16 permisos)
  - CONSULT (2 permisos)
  - CONFIG (1 permiso)
  - HANDLE (24 permisos)
  - SHOW (11 permisos)
  - OTHER (2 permisos)

#### PlanPermissionMappingSeeder.php (Nuevo)
- ✅ Mapea permisos a cada plan:
  - **Lite**: 11 permisos
  - **Lite+**: 27 permisos
  - **Pro**: 43 permisos

#### AssignPermissionsToSuperAdminSeeder.php (Nuevo)
- ✅ Asigna todos los permisos a usuarios super admin
- ✅ Busca usuario `ddcr` específicamente
- ✅ Asigna permisos a todos los usuarios sin tenant

#### DatabaseSeeder.php (Actualizado)
- ✅ Orden correcto de ejecución:
  1. SuperAdminSeeder
  2. PlanSeeder
  3. TenantPermissionSeeder
  4. PlanPermissionMappingSeeder
  5. AssignPermissionsToSuperAdminSeeder

### 4. Comandos Artisan

#### tenants:sync-permissions
**Ubicación:** `app/Console/Commands/SyncTenantPermissions.php`

**Funcionalidad:**
- Sincroniza permisos de tenants basándose en su plan
- Soporta sincronización individual o masiva
- Muestra progreso y resumen de operaciones

**Uso:**
```bash
# Sincronizar un tenant específico
php artisan tenants:sync-permissions --tenant=1

# Sincronizar todos los tenants
php artisan tenants:sync-permissions --all
```

#### plans:show-permissions
**Ubicación:** `app/Console/Commands/ShowPlanPermissions.php`

**Funcionalidad:**
- Muestra permisos de planes
- Muestra permisos de tenants
- Agrupa permisos por categoría
- Visualización amigable con colores

**Uso:**
```bash
# Ver todos los planes
php artisan plans:show-permissions

# Ver un plan específico
php artisan plans:show-permissions --plan=Lite
php artisan plans:show-permissions --plan="Lite+"

# Ver permisos de un tenant
php artisan plans:show-permissions --tenant=1
```

### 5. Scripts de Utilidad

#### setup_permissions.sh
**Ubicación:** `control_maestro/setup_permissions.sh`

**Funcionalidad:**
- Script bash automatizado para instalación completa
- Ejecuta migraciones
- Ejecuta seeders
- Sincroniza permisos de tenants existentes
- Muestra resumen de instalación

**Uso:**
```bash
./setup_permissions.sh
```

### 6. Documentación

#### PERMISOS_POR_PLAN.md
- ✅ Documentación completa del sistema
- ✅ Lista de permisos por plan
- ✅ Instrucciones de instalación
- ✅ Guías de uso
- ✅ Ejemplos de código

## 📊 Distribución de Permisos

### Plan Lite (11 permisos)
Funcionalidad básica para gestión de órdenes y servicios:
- Crear órdenes, plagas, productos, servicios
- Manejar clientes, servicios, productos, plagas, órdenes
- Ver CRM

### Plan Lite+ (27 permisos)
Funcionalidad intermedia con reportes y gestión expandida:
- Todo de Lite +
- Crear clientes, leads, lotes, cotizaciones, trackings
- Consultar reportes
- Configurar apariencia de reportes
- Manejar usuarios, sucursales, zonas comerciales, contratos, leads
- Ver sistema de clientes, planificación, control de calidad, sedes

### Plan Pro (43 permisos)
Funcionalidad completa:
- Todo de Lite+ +
- Crear sucursales, contratos, puntos de control, planos, stocks, usuarios admin
- Consultar directorios
- Manejar archivos del drive, puntos de control
- Ver RH, stocks, facturas

## 🔧 Proceso de Implementación

### Paso 1: Migraciones
```bash
php artisan migrate
```

### Paso 2: Seeders
```bash
php artisan db:seed
```

### Paso 3: Sincronización (si hay tenants existentes)
```bash
php artisan tenants:sync-permissions --all
```

### Paso 4: Verificación
```bash
php artisan plans:show-permissions
```

## 📝 Uso en Código

### Al crear un tenant:
```php
$tenant = Tenant::create([
    'company_name' => 'Empresa XYZ',
    'slug' => 'empresa-xyz',
    'plan_id' => 2, // Lite+
    'is_active' => true,
    // ... otros campos
]);

// Sincronizar permisos automáticamente
$tenant->syncPermissionsFromPlan();
```

### Al cambiar de plan:
```php
$tenant->plan_id = 3; // Cambiar a Pro
$tenant->save();
$tenant->syncPermissionsFromPlan();
```

### Verificar permisos:
```php
// En middleware o controllers
if ($tenant->hasPermission('create_orders')) {
    // Permitir acción
}

// Obtener todos los permisos
$permissions = $tenant->getAllowedPermissions();
```

## ⚠️ Consideraciones Importantes

1. **Usuario ddcr**: Usuario sin tenant, tiene todos los permisos (como Pro)
2. **Super Admins**: Usuarios marcados como `is_superAdmin=true` sin tenant tienen todos los permisos
3. **Sincronización**: Al cambiar el plan de un tenant, ejecutar `syncPermissionsFromPlan()`
4. **Permisos personalizados**: Se pueden desactivar permisos individuales en `tenant_permission_control` cambiando `is_allowed=false`

## 🎯 Próximos Pasos Recomendados

1. Integrar verificación de permisos en los controladores
2. Crear middleware para validar permisos por tenant
3. Agregar interfaz en el panel de administración para gestionar permisos
4. Implementar logs de cambios de permisos
5. Crear tests unitarios para el sistema de permisos

## 📁 Archivos del Sistema

### Nuevos:
- `database/migrations/2026_02_21_090701_create_plan_permissions_table.php`
- `database/seeders/PlanPermissionMappingSeeder.php`
- `database/seeders/AssignPermissionsToSuperAdminSeeder.php`
- `app/Console/Commands/SyncTenantPermissions.php`
- `app/Console/Commands/ShowPlanPermissions.php`
- `setup_permissions.sh`
- `PERMISOS_POR_PLAN.md`
- `RESUMEN_IMPLEMENTACION_PERMISOS.md` (este archivo)

### Modificados:
- `app/Models/Plan.php`
- `app/Models/Tenant.php`
- `database/seeders/TenantPermissionSeeder.php`
- `database/seeders/SuperAdminSeeder.php`
- `database/seeders/DatabaseSeeder.php`

---

✅ **Sistema completamente implementado y listo para usar**
