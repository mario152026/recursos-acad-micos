@extends('layouts.admin')

@section('title', 'Usuarios — Admin')

@section('content')
    <h1 class="mb-4">Gestión de Usuarios</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($usuarios->isEmpty())
        <div class="alert alert-info">No hay usuarios registrados.</div>
    @else
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role_id === 1 ? 'Admin' : 'Usuario' }}</td>
                    <td>
                            <span class="badge bg-{{ $u->activo ? 'success' : 'secondary' }}">
                                {{ $u->activo ? 'Sí' : 'No' }}
                            </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group" role="group" aria-label="Acciones usuario">
                            {{-- Activar / Desactivar --}}
                            <form action="{{ route('admin.usuarios.toggle', $u) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-{{ $u->activo ? 'warning' : 'success' }}"
                                    title="{{ $u->activo ? 'Desactivar usuario' : 'Activar usuario' }}"
                                >
                                    {{ $u->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>

                            {{-- Cambiar rol --}}
                            <form action="{{ route('admin.usuarios.role', $u) }}"
                                  method="POST"
                                  class="d-inline ms-1">
                                @csrf
                                @method('PATCH')
                                <select name="role_id"
                                        class="form-select form-select-sm d-inline w-auto align-middle"
                                        title="Cambiar rol">
                                    <option value="2" {{ $u->role_id === 2 ? 'selected' : '' }}>Usuario</option>
                                    <option value="1" {{ $u->role_id === 1 ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit"
                                        class="btn btn-sm btn-primary ms-1"
                                        title="Guardar rol">
                                    Guardar
                                </button>
                            </form>

                            {{-- Eliminar usuario --}}
                            <form action="{{ route('admin.usuarios.destroy', $u) }}"
                                  method="POST"
                                  class="d-inline ms-1"
                                  onsubmit="return confirm('¿Eliminar usuario {{ $u->name }}? Esta acción no se puede deshacer.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar usuario">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $usuarios->links() }}
    @endif
@endsection
