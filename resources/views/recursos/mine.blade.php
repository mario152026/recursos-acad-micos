{{-- resources/views/recursos/mine.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.public')

@section('title', 'Mis Recursos')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Mis Recursos</h1>

        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('recursos.mine') }}" class="row g-2 mb-4 align-items-end">
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
                        <option value="{{ $c->id }}" @selected(request('categoria') == $c->id)>
                            {{ $c->nombre_asignatura }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="nivel" class="form-label">Nivel educativo</label>
                <select id="nivel" name="nivel" class="form-select">
                    <option value="">— Todos —</option>
                    @foreach($niveles as $n)
                        <option value="{{ $n->id }}" @selected(request('nivel') == $n->id)>
                            {{ $n->nombre_nivel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                @if(request()->filled('search') || request()->filled('categoria') || request()->filled('nivel'))
                    <a href="{{ route('recursos.mine') }}" class="btn btn-link mt-1">Limpiar</a>
                @endif
            </div>
        </form>

        {{-- Listado de recursos --}}
        @if($recursos->isEmpty())
            <div class="alert alert-info">No has subido ningún recurso.</div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($recursos as $recurso)
                    @php
                        $ext = strtolower(pathinfo($recurso->archivo_url, PATHINFO_EXTENSION));
                    @endphp
                    <div class="col">
                        <div class="card h-100">
                            {{-- Previsualización --}}
                            @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/' . $recurso->archivo_url) }}"
                                     class="card-img-top"
                                     alt="{{ $recurso->titulo }}">
                            @elseif(in_array($ext, ['mp4','mov','avi']))
                                <video class="card-img-top" muted preload="metadata" loop>
                                    <source src="{{ asset('storage/' . $recurso->archivo_url) }}" type="video/{{ $ext }}">
                                    Tu navegador no soporta este vídeo.
                                </video>
                            @else
                                <div class="bg-secondary text-white text-center py-5">
                                    <i class="bi bi-file-earmark display-1"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $recurso->titulo }}</h5>
                                <p class="card-text">{{ Str::limit($recurso->descripcion, 100) }}</p>

                                <div class="mt-auto">
                                    <a href="{{ route('recursos.show', $recurso) }}"
                                       class="btn btn-sm btn-primary">
                                        Ver
                                    </a>
                                    <a href="{{ route('recursos.edit', $recurso) }}"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('recursos.destroy', $recurso) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este recurso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <small>{{ $recurso->created_at->format('Y-m-d') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $recursos->links() }}
            </div>
        @endif
    </div>
@endsection
