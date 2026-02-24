#!/bin/bash

# Script para configurar el sistema de permisos por plan
# Autor: Control Maestro
# Fecha: 2026-02-21

echo "=========================================="
echo "Sistema de Permisos por Plan - Instalación"
echo "=========================================="
echo ""

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Función para mostrar errores
error() {
    echo -e "${RED}✗ Error: $1${NC}"
}

# Función para mostrar éxito
success() {
    echo -e "${GREEN}✓ $1${NC}"
}

# Función para mostrar advertencias
warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Función para mostrar info
info() {
    echo -e "→ $1"
}

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    error "Este script debe ejecutarse desde la raíz del proyecto Laravel"
    exit 1
fi

success "Directorio correcto detectado"
echo ""

# Paso 1: Ejecutar migraciones
info "Paso 1: Ejecutando migraciones..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    success "Migraciones ejecutadas correctamente"
else
    error "Falló la ejecución de migraciones"
    exit 1
fi
echo ""

# Paso 2: Ejecutar seeders
info "Paso 2: Ejecutando seeders..."
php artisan db:seed --force

if [ $? -eq 0 ]; then
    success "Seeders ejecutados correctamente"
else
    warning "Hubo un problema con los seeders. Continuar de todas formas? (y/n)"
    read -r response
    if [[ ! "$response" =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi
echo ""

# Paso 3: Sincronizar permisos de tenants existentes
info "Paso 3: Sincronizando permisos de tenants existentes..."
php artisan tenants:sync-permissions --all

if [ $? -eq 0 ]; then
    success "Permisos sincronizados correctamente"
else
    warning "Algunos tenants podrían no haberse sincronizado"
fi
echo ""

# Resumen
echo "=========================================="
echo "Resumen de la instalación"
echo "=========================================="
success "Sistema de permisos por plan instalado correctamente"
echo ""
info "Planes configurados:"
echo "  - Lite (11 permisos)"
echo "  - Lite+ (27 permisos)"
echo "  - Pro (43 permisos)"
echo ""
info "Comandos disponibles:"
echo "  php artisan tenants:sync-permissions --tenant=ID"
echo "  php artisan tenants:sync-permissions --all"
echo ""
info "Consulta PERMISOS_POR_PLAN.md para más información"
echo ""
success "¡Instalación completada!"
