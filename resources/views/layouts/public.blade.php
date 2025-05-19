{{-- resources/views/layouts/public.blade.php --}}
@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $settings['site_title'] }}{{-- — @yield('title') --}}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tus estilos propios -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

{{-- ===== NAVBAR PÚBLICO (width full) ===== --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-recursos2.png') }}"
                 alt="Logo Recursos Académicos"
                 style="height:60px; width:auto; margin-right:8px;">
            <span class="fw-bold">{{ $settings['site_title'] }}</span>
        </a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navPublic">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPublic">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recursos.index') }}">
                        Explorar Recursos
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('recursos.create') }}">
                            Subir Recurso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('recursos.mine') }}">
                            Mis Recursos
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('profile.edit') }}">
                                    Mi perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST"
                                      action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="dropdown-item text-danger">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Si la vista define sección ’hero’, se inyecta encima del container --}}
@if(View::hasSection('hero'))
    @yield('hero')
@endif

{{-- Contenedor principal para el resto de contenido --}}
<main class="container py-4">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-light text-muted pt-4 border-top">
    <div class="container">
        <div class="row">
            <!-- Recursos -->
            <div class="col-sm-4 mb-3">
                <h6>Recursos</h6>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('recursos.index') }}">
                            Todos los recursos
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('recursos.mine') }}">
                                Mis recursos
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
            <!-- Contacto -->
            <div class="col-sm-4 mb-3">
                <h6>Contacto</h6>
                <p>
                    <i class="bi bi-envelope"></i> soporte@recursos.edu<br>
                    <i class="bi bi-phone"></i> +34 600 123 456
                </p>
                <h6>Síguenos</h6>
                <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
            </div>
            <!-- Info adicional -->
            <div class="col-sm-4 mb-3">
                {{-- Aquí más enlaces si quieres --}}
            </div>
        </div>

        <div class="text-center py-3">
            &copy; {{ date('Y') }} {{ $settings['site_title'] }}.
            Todos los derechos reservados.
        </div>
    </div>
</footer>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
