@extends('layouts.admin')

@section('title', 'Recursos — Admin')

@section('content')
    <h1 class="mb-4">Gestión de Recursos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario de filtros --}}
    <form method="GET" action="{{ route('admin.recursos.index') }}" class="row mb-4 g-2 align-items-end">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar título</label>
            <input
                type="text"
                id="search"
                name="search"
                class="form-control"
                placeholder="Escribe parte del título..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select id="categoria" name="categoria" class="form-select">
                <option value="">— Todas —</option>
                @foreach($categorias as $c)
                    <option
                        value="{{ $c->id }}"
                        @selected(request('categoria') == $c->id)
                    >{{ $c->nombre_asignatura }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="nivel" class="form-label">Nivel educativo</label>
            <select id="nivel" name="nivel" class="form-select">
                <option value="">— Todos —</option>
                @foreach($niveles as $n)
                    <option
                        value="{{ $n->id }}"
                        @selected(request('nivel') == $n->id)
                    >{{ $n->nombre_nivel }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            @if(request()->filled('search') || request()->filled('categoria') || request()->filled('nivel'))
                <a href="{{ route('admin.recursos.index') }}" class="btn btn-link mt-1">Limpiar</a>
            @endif
        </div>
    </form>

    @if($recursos->isEmpty())
        <div class="alert alert-info">No hay recursos cargados.</div>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Usuario</th>
                <th>Categoría</th>
                <th>Nivel</th>
                <th>Fecha</th>
                <th>Activo</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recursos as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->titulo }}</td>
                    <td>{{ optional($r->usuario)->name ?? '—' }}</td>
                    <td>{{ optional($r->asignatura)->nombre_asignatura }}</td>
                    <td>{{ optional($r->nivel)->nombre_nivel }}</td>
                    <td>{{ $r->created_at->format('Y-m-d') }}</td>
                    <td>
                            <span class="badge bg-{{ $r->activo ? 'success' : 'secondary' }}">
                                {{ $r->activo ? 'Sí' : 'No' }}
                            </span>
                    </td>
                    <td class="text-end">
                        {{-- Toggle activo/inactivo --}}
                        <form
                            action="{{ route('admin.recursos.toggle', $r) }}"
                            method="POST"
                            class="d-inline"
                        >
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="btn btn-sm btn-{{ $r->activo ? 'warning' : 'success' }}"
                            >
                                {{ $r->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>

                        {{-- Eliminar recurso --}}
                        <form
                            action="{{ route('admin.recursos.destroy', $r) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('¿Eliminar recurso #{{ $r->id }}?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Borrar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center my-4">
            {{ $recursos->links() }}
        </div>
    @endif
@endsection
