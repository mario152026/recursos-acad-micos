{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.public')

@section('title', 'Bienvenido — Recursos Académicos')

{{-- Hero full-width sin botón de registro --}}
@section('hero')
    <section class="container-fluid px-0 position-relative overflow-hidden" style="height: 80vh;">
        <img src="{{ asset('images/grand-wood-library.png') }}"
             alt="Biblioteca"
             class="w-100 h-100 object-fit-cover">
        <div class="position-absolute top-0 start-0 w-100 h-100"
             style="background: rgba(0,0,0,0.5);"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3">
            <!-- Logo en vez de texto -->
            <img src="{{ asset('images/logo-recursos2.png') }}"
                 alt="Recursos Académicos"
                 class="mb-3"
                 style="height: 150px; width: auto;">
            <h1 class="display-3 fw-bold">Recursos Académicos</h1>
            <p class="lead mb-4">Explora, comparte y aprende con nuestra comunidad educativa</p>
            <a href="{{ route('recursos.index') }}" class="btn btn-primary btn-lg me-2 shadow">
                <i class="bi bi-search me-1"></i> Explorar Recursos
            </a>
            {{-- ya no hay “Regístrate” aquí --}}
        </div>
    </section>
@endsection

@section('content')
    <!-- Características en fondo claro -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <i class="bi bi-folder2-open display-4 text-primary mb-3"></i>
                    <h5>Categorizado</h5>
                    <p>Encuentra recursos agrupados por asignatura y nivel educativo.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-chat-dots display-4 text-success mb-3"></i>
                    <h5>Valoraciones</h5>
                    <p>Lee opiniones y califica cada recurso con estrellas y comentarios.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-flag display-4 text-danger mb-3"></i>
                    <h5>Moderación</h5>
                    <p>Reporta contenido inapropiado para que nuestros administradores lo revisen.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Características en fondo claro -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <i class="bi bi-sliders display-4" style="color:#6f42c1; margin-bottom:1rem;"></i>
                    <h5>Búsqueda Avanzada</h5>
                    <p>Filtra recursos por título, fecha o popularidad para encontrar justo lo que necesitas</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-download display-4" style="color: #ffc107; margin-bottom:1rem;"></i>
                    <h5>Descarga</h5>
                    <p>Descarga los archivos de los recursos para usarlos sin conexión.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-share-fill display-4" style="color:#e83e8c; margin-bottom:1rem;"></i>
                    <h5>Comparte</h5>
                    <p>Comparte enlaces a recursos con tus compañeros o por redes sociales con un solo clic.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
