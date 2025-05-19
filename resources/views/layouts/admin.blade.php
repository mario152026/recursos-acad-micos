{{-- resources/views/layouts/admin.blade.php --}}
@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    {{-- Título dinámico según setting --}}
    <title>{{ $settings['site_title'] }} — @yield('title','Panel de Administración')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS propio de Admin -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

{{-- NAVBAR ADMIN --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        {{-- Marca con título dinámico --}}
        <a class="navbar-brand" href="{{ route('admin.home') }}">
            {{ $settings['site_title'] }} <small class="text-muted">– Admin</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.recursos.index') }}">Recursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.reportes.index') }}">Reportes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.usuarios.index') }}">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.settings.edit') }}">
                        Ajustes
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->nombre }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Mi perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENIDO + SIDEBAR --}}
<div class="container-fluid flex-grow-1">
    <div class="row">
        {{-- Sidebar lateral --}}
        <aside class="col-md-2 d-none d-md-block bg-light sidebar py-4">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.home') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.recursos.index') }}">
                        <i class="bi bi-folder2-open"></i> Recursos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.reportes.index') }}">
                        <i class="bi bi-flag"></i> Reportes
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.usuarios.index') }}">
                        <i class="bi bi-people"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.settings.edit') }}">
                        <i class="bi bi-gear-fill"></i> Ajustes
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Área principal --}}
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 py-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- FOOTER --}}
<footer class="bg-dark text-white text-center py-3 mt-auto">
    &copy; {{ date('Y') }} {{ $settings['site_title'] }} — Panel de Administración
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
