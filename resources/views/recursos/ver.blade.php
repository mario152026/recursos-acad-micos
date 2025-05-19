{{-- resources/views/recursos/ver.blade.php --}}
@extends('layouts.public')

@section('title', $recurso->titulo)

@section('content')
    <div class="container py-5">

        {{-- Card principal --}}
        <div class="card border-0 shadow-lg mb-5">
            @php
                $ext = strtolower(pathinfo($recurso->archivo_url, PATHINFO_EXTENSION));
            @endphp

            {{-- Cabecera (imagen o vídeo) --}}
            @if(in_array($ext, ['jpg','jpeg','png','gif']))
                <img src="{{ asset('storage/' . $recurso->archivo_url) }}"
                     class="card-img-top"
                     alt="{{ $recurso->titulo }}">
            @elseif(in_array($ext, ['mp4','mov','avi']))
                <video controls class="w-100 rounded-top">
                    <source src="{{ asset('storage/' . $recurso->archivo_url) }}" type="video/{{ $ext }}">
                    Tu navegador no soporta reproducir este vídeo.
                </video>
            @endif

            <div class="card-body">
                {{-- Título y metadatos --}}
                <h2 class="card-title fw-bold mb-3">{{ $recurso->titulo }}</h2>
                <div class="mb-4 text-muted small">
                    <i class="bi bi-folder2-open me-1"></i>
                    {{ optional($recurso->asignatura)->nombre_asignatura ?? 'Sin categoría' }}
                    &bull;
                    <i class="bi bi-bar-chart-line me-1 ms-2"></i>
                    {{ optional($recurso->nivel)->nombre_nivel ?? 'Sin nivel' }}
                    &bull;
                    <i class="bi bi-clock me-1 ms-2"></i>
                    {{ $recurso->created_at->format('d/m/Y H:i') }}
                </div>

                {{-- Descripción --}}
                <p class="mb-5">{{ $recurso->descripcion }}</p>

                {{-- Acción de descarga --}}
                <div class="mb-5">
                    @auth
                        <a href="{{ asset('storage/' . $recurso->archivo_url) }}"
                           class="btn btn-lg btn-success me-2"
                           download>
                            <i class="bi bi-download me-1"></i> Descargar
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn btn-lg btn-outline-primary">
                            <i class="bi bi-download me-1"></i> Inicia sesión para descargar
                        </a>
                    @endauth
                </div>

                {{-- Sección de valoraciones --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-4">Valoraciones y Comentarios</h5>

                    @forelse($recurso->valoraciones as $v)
                        <div class="mb-4 p-4 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ optional($v->usuario)->name ?? $v->usuario->email }}</strong>
                                    <span class="text-muted small">— {{ $v->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-warning">
                                    {!! str_repeat('<i class="bi bi-star-fill"></i>', $v->calificacion) !!}
                                </div>
                            </div>
                            @if($v->comentario)
                                <p class="mb-0">{{ $v->comentario }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Todavía no hay valoraciones.</p>
                    @endforelse

                    @auth
                        <form action="{{ route('recursos.valoraciones.store', $recurso) }}"
                              method="POST"
                              class="mt-4">
                            @csrf
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <select name="calificacion"
                                            class="form-select form-select-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} ★</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-sm">Valorar</button>
                                </div>
                            </div>
                            <div class="mt-3">
                            <textarea name="comentario"
                                      rows="3"
                                      class="form-control @error('comentario') is-invalid @enderror"
                                      placeholder="Comentario (opcional)">{{ old('comentario') }}</textarea>
                                @error('comentario')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    @else
                        <p>
                            <a href="{{ route('login') }}">Inicia sesión</a> para valorar.
                        </p>
                    @endauth
                </section>

                {{-- Sección de reporte --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-4">Reportar Contenido</h5>

                    @auth
                        <form action="{{ route('recursos.reportes.store', $recurso) }}"
                              method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text"
                                       name="motivo"
                                       class="form-control @error('motivo') is-invalid @enderror"
                                       placeholder="Motivo del reporte"
                                       value="{{ old('motivo') }}"
                                       required>
                                <button class="btn btn-danger">Reportar</button>
                            </div>
                            @error('motivo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </form>
                    @else
                        <p>
                            <a href="{{ route('login') }}">Inicia sesión</a> para reportar contenido.
                        </p>
                    @endauth
                </section>

                {{-- Enlace de retorno --}}
                <div class="text-end">
                    <a href="{{ route('recursos.index') }}"
                       class="btn btn-link">
                        <i class="bi bi-arrow-left me-1"></i> Volver a Explorar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
