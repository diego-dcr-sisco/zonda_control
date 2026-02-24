# Checklist de Verificación - Sistema de Permisos

## ✅ Pre-instalación

- [ ] Base de datos configurada correctamente
- [ ] Laravel funcionando
- [ ] Spatie Permission instalado
- [ ] Seeders anteriores ejecutados (SimpleRole, Status, etc.)

## ✅ Instalación

### Opción 1: Script Automático
```bash
cd /home/diego-dcr/Documentos/siscoplagas/ERP/ZONDA/control_maestro
./setup_permissions.sh
```

### Opción 2: Manual

1. **Migrar la base de datos**
```bash
php artisan migrate
```
- [ ] Tabla `plan_permissions` creada

2. **Ejecutar seeders**
```bash
php artisan db:seed
```
- [ ] SuperAdminSeeder ejecutado
- [ ] PlanSeeder ejecutado (Lite, Lite+, Pro)
- [ ] TenantPermissionSeeder ejecutado (62 permisos)
- [ ] PlanPermissionMappingSeeder ejecutado
- [ ] AssignPermissionsToSuperAdminSeeder ejecutado

3. **Sincronizar tenants existentes**
```bash
php artisan tenants:sync-permissions --all
```
- [ ] Permisos sincronizados para todos los tenants

## ✅ Verificación

### 1. Verificar planes
```bash
php artisan plans:show-permissions
```
**Resultado esperado:**
- [ ] Plan Lite: 11 permisos
- [ ] Plan Lite+: 27 permisos
- [ ] Plan Pro: 43 permisos

### 2. Verificar un tenant
```bash
php artisan plans:show-permissions --tenant=1
```
**Resultado esperado:**
- [ ] Muestra información del tenant
- [ ] Muestra plan asignado
- [ ] Lista permisos activos

### 3. Verificar permisos en base de datos

```sql
-- Contar permisos por plan
SELECT p.name, COUNT(pp.permission_id) as permisos 
FROM plans p 
LEFT JOIN plan_permissions pp ON p.id = pp.plan_id 
GROUP BY p.id, p.name;
```

**Resultado esperado:**
```
Lite  : 11
Lite+ : 27
Pro   : 43
```

### 4. Verificar permisos de un tenant específico

```sql
-- Ver permisos de tenant 1
SELECT p.name 
FROM tenant_permission_control tpc
JOIN permissions p ON tpc.permission_id = p.id
WHERE tpc.tenant_id = 1 AND tpc.is_allowed = true
ORDER BY p.name;
```

### 5. Verificar super admin

```bash
php artisan tinker
>>> $user = User::where('is_superAdmin', true)->first();
>>> $user->getAllPermissions()->pluck('name');
```

**Resultado esperado:**
- [ ] Usuario tiene todos los permisos de categoría 't'

## ✅ Tests Funcionales

### Test 1: Crear tenant y sincronizar
```bash
php artisan tinker
```

```php
// Crear tenant con plan Lite
$tenant = Tenant::create([
    'company_name' => 'Test Empresa',
    'slug' => 'test-empresa',
    'plan_id' => 1, // Lite
    'is_active' => true,
    'path' => '/test',
]);

// Sincronizar permisos
$tenant->syncPermissionsFromPlan();

// Verificar
$tenant->getAllowedPermissions()->count(); // Debe ser 11
$tenant->hasPermission('create_orders'); // Debe ser true
$tenant->hasPermission('create_stocks'); // Debe ser false
```

- [ ] Tenant creado correctamente
- [ ] 11 permisos asignados
- [ ] Permisos correctos según plan

### Test 2: Upgrade de plan
```php
// Actualizar a Pro
$tenant->plan_id = 3;
$tenant->save();
$tenant->syncPermissionsFromPlan();

// Verificar
$tenant->getAllowedPermissions()->count(); // Debe ser 43
$tenant->hasPermission('create_stocks'); // Ahora debe ser true
```

- [ ] Permisos actualizados a 43
- [ ] Nuevos permisos disponibles

### Test 3: Downgrade de plan
```php
// Volver a Lite
$tenant->plan_id = 1;
$tenant->save();
$tenant->syncPermissionsFromPlan();

// Verificar
$tenant->getAllowedPermissions()->count(); // Debe ser 11 otra vez
$tenant->hasPermission('create_stocks'); // Debe ser false
```

- [ ] Permisos reducidos correctamente
- [ ] Permisos restringidos según plan

## ✅ Comandos Disponibles

### Información
- [ ] `php artisan plans:show-permissions` - Ver todos los planes
- [ ] `php artisan plans:show-permissions --plan=Lite` - Ver plan específico
- [ ] `php artisan plans:show-permissions --tenant=1` - Ver permisos de tenant

### Sincronización
- [ ] `php artisan tenants:sync-permissions --tenant=1` - Sincronizar un tenant
- [ ] `php artisan tenants:sync-permissions --all` - Sincronizar todos

## ✅ Archivos Creados/Modificados

### Migraciones
- [ ] `database/migrations/2026_02_21_090701_create_plan_permissions_table.php`

### Seeders
- [ ] `database/seeders/TenantPermissionSeeder.php` (modificado)
- [ ] `database/seeders/PlanPermissionMappingSeeder.php` (nuevo)
- [ ] `database/seeders/AssignPermissionsToSuperAdminSeeder.php` (nuevo)
- [ ] `database/seeders/SuperAdminSeeder.php` (modificado)
- [ ] `database/seeders/DatabaseSeeder.php` (modificado)

### Modelos
- [ ] `app/Models/Plan.php` (modificado)
- [ ] `app/Models/Tenant.php` (modificado)

### Comandos
- [ ] `app/Console/Commands/SyncTenantPermissions.php` (nuevo)
- [ ] `app/Console/Commands/ShowPlanPermissions.php` (nuevo)

### Scripts
- [ ] `setup_permissions.sh` (nuevo)

### Documentación
- [ ] `PERMISOS_POR_PLAN.md` (nuevo)
- [ ] `RESUMEN_IMPLEMENTACION_PERMISOS.md` (nuevo)
- [ ] `EJEMPLOS_USO_PERMISOS.md` (nuevo)
- [ ] `CHECKLIST_VERIFICACION.md` (este archivo)

## ✅ Integración en Aplicación

### En Controllers
- [ ] Verificar permisos antes de acciones
- [ ] Manejar casos sin permisos
- [ ] Redirigir apropiadamente

### En Middleware
- [ ] Crear middleware de verificación
- [ ] Aplicar a rutas protegidas
- [ ] Manejar excepciones

### En Vistas
- [ ] Mostrar/ocultar opciones según permisos
- [ ] Indicar plan actual
- [ ] Mostrar opción de upgrade

### En API
- [ ] Endpoint para consultar permisos
- [ ] Validar permisos en requests
- [ ] Retornar errores apropiados

## ⚠️ Problemas Comunes

### Problema: Tenant sin permisos
**Solución:**
```bash
php artisan tenants:sync-permissions --tenant=ID
```

### Problema: Plan sin permisos
**Verificar:**
```bash
php artisan plans:show-permissions --plan=NOMBRE
```
**Si no tiene permisos, ejecutar:**
```bash
php artisan db:seed --class=PlanPermissionMappingSeeder
```

### Problema: Super admin sin permisos
**Solución:**
```bash
php artisan db:seed --class=AssignPermissionsToSuperAdminSeeder
```

### Problema: Permisos no actualizados después de cambio de plan
**Solución:**
```bash
php artisan tinker
>>> $tenant = Tenant::find(ID);
>>> $tenant->syncPermissionsFromPlan();
```

## ✅ Mantenimiento

### Agregar nuevo permiso

1. Agregar en `TenantPermissionSeeder.php`:
```php
['name' => 'nuevo_permiso', 'category' => 't', 'type' => 'w'],
```

2. Agregar a planes en `PlanPermissionMappingSeeder.php`:
```php
'Pro' => [
    // ... permisos existentes
    'nuevo_permiso',
],
```

3. Ejecutar:
```bash
php artisan db:seed --class=TenantPermissionSeeder
php artisan db:seed --class=PlanPermissionMappingSeeder
php artisan tenants:sync-permissions --all
```

### Cambiar permisos de un plan

1. Modificar array en `PlanPermissionMappingSeeder.php`
2. Ejecutar:
```bash
php artisan db:seed --class=PlanPermissionMappingSeeder
php artisan tenants:sync-permissions --all
```

## 📊 Métricas de Verificación

Al finalizar la instalación, deberías tener:

- **Permisos totales:** 62
- **Planes:** 3 (Lite, Lite+, Pro)
- **Relaciones plan-permiso:** 81 (11 + 27 + 43)
- **Comandos artisan:** 2 nuevos
- **Seeders:** 5 ejecutados
- **Migraciones:** 1 nueva

## ✅ Aprobación Final

- [ ] Todos los tests pasaron
- [ ] Documentación revisada
- [ ] Comandos funcionan correctamente
- [ ] Permisos asignados según plan
- [ ] Super admin tiene todos los permisos
- [ ] Tenants existentes sincronizados
- [ ] Sistema listo para producción

---

**Fecha de verificación:** _______________  
**Verificado por:** _______________  
**Resultado:** [ ] ✅ Aprobado  [ ] ⚠️ Con observaciones  [ ] ❌ Requiere corrección
