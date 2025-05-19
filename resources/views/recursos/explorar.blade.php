{{-- resources/views/recursos/explorar.blade.php --}}
@extends('layouts.public')

@section('title', 'Explorar Recursos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Explorar Recursos</h2>
        @auth
            <a href="{{ route('recursos.create') }}" class="btn btn-primary">
                <i class="bi bi-upload"></i> Subir Recurso
            </a>
        @endauth
    </div>

    <form action="{{ route('recursos.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar por título…">
        </div>
        <div class="col-md-3">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre_asignatura }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="nivel" class="form-select">
                <option value="">Todos los niveles</option>
                @foreach($niveles as $nivel)
                    <option value="{{ $nivel->id }}" {{ request('nivel') == $nivel->id ? 'selected' : '' }}>
                        {{ $nivel->nombre_nivel }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </div>
    </form>

    @if($recursos->isEmpty())
        <div class="alert alert-info">No hay recursos disponibles.</div>
    @else
        <div class="row">
            @foreach($recursos as $recurso)
                @php
                    $ext = strtolower(pathinfo($recurso->archivo_url, PATHINFO_EXTENSION));
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
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
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($recurso->descripcion, 80) }}</p>
                            <a href="{{ route('recursos.show', $recurso) }}"
                               class="btn btn-outline-primary btn-sm mt-auto">
                                Ver
                            </a>
                        </div>
                        <div class="card-footer text-muted">
                            <small>{{ $recurso->created_at->format('Y-m-d') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $recursos->links() }}
        </div>
    @endif
@endsection
