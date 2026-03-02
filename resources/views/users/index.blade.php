@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('subscriptions.index')}}" class="col-auto btn-primary p-0 fs-3">
                        <i class="bi bi-arrow-left fs-4"></i>
                    </a>
                    <h4 class="mb-2 fw-bold">
                        USUARIOS DEL SISTEMA
                    </h4>
                </div>
                
                <!-- Botón para crear nuevo usuario -->
                <div class="dropdown">
                    @if($branches->count() === 1)
                        <!-- Si solo hay una sucursal, botón directo -->
                        <a href="{{ route('subscriptions.branch.user.create', ['id' => $tenantId, 'branch' => $branches->first()->id]) }}" 
                           class="btn btn-primary d-flex align-items-center gap-2" 
                           style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-user-plus"></i>
                            <span>Crear Usuario</span>
                        </a>
                    @else
                        <!-- Si hay múltiples sucursales, dropdown -->
                        <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" 
                                type="button" 
                                id="dropdownCreateUser" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-user-plus"></i>
                            <span>Crear Usuario</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownCreateUser">
                            <li><h6 class="dropdown-header">Seleccionar Sucursal</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($branches as $branch)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" 
                                       href="{{ route('subscriptions.branch.user.create', ['id' => $tenantId, 'branch' => $branch->id]) }}">
                                        <i class="fas fa-building text-primary"></i>
                                        <span>{{ $branch->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de usuarios -->
    <div class="container-fluid mt-4">
        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold" scope="col">ID</th>
                                <th class="fw-bold" scope="col">Nombre</th>
                                <th class="fw-bold" scope="col">Usuario</th>
                                <th class="fw-bold" scope="col">Email</th>
                                <th class="fw-bold" scope="col">Rol</th>
                                <th class="fw-bold" scope="col">Departamento</th>
                                <th class="fw-bold" scope="col">Estado</th>
                                <th class="fw-bold" scope="col">Fecha Creación</th>
                                <th class="fw-bold" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($users as $user)
                                <tr id="user{{ $user->id }}">
                                    <th>{{ $user->id }}</th>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-user-circle text-muted"></i>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->simpleRole->name ?? '-' }}</td>
                                    <td>{{ $user->workDepartment->name ?? '-' }}</td>
                                    <td>{{ $user->status->name }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-options" role="group">
                                            <!-- Botón de editar -->
                                            <a href="{{ route('subscriptions.users.edit', ['id' => $tenantId, 'userId' => $user->id]) }}" class="btn btn-action btn-bk" title="Editar usuario">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Botón de eliminar -->
                                            {{-- <button type="button" class="btn btn-action btn-bk btn-danger" 
                                                    title="Eliminar usuario"
                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                 <!-- Paginación -->
                {{-- @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $users->firstItem() }} - {{ $users->lastItem() }} de {{ $users->total() }} usuarios
                    </div>
                    <nav>
                        {{ $users->links() }}
                    </nav>
                </div>
                @endif
                --}}
            </div>
        
    </div>
</div>



<style>
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin-right: 8px;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }

    .btn-group-options {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-action {
        padding: 8px 12px;
        border: none;
        background: #cbcacaff;
        color: #495057;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-action:not(:last-child) {
        border-right: 1px solid #dee2e6;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-bk:hover { background: #ffc107; }
    .btn-action.btn-danger:hover { background: #dc3545; }

    .btn-action i {
        transition: transform 0.2s ease;
    }

    .btn-action:hover i {
        transform: scale(1.1);
    }

    .form-check-input {
        transition: all 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-group-options {
            display: flex;
            flex-direction: column;
        }
        
        .btn-action:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection