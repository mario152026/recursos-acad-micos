{{-- resources/views/admin/settings/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ajustes — Admin')

@section('content')
    <h1 class="mb-4">Ajustes Globales</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PATCH') {{-- Aquí indicamos que realmente es PATCH --}}

        <div class="mb-3">
            <label for="site_title" class="form-label">Título del sitio</label>
            <input
                id="site_title"
                name="site_title"
                type="text"
                class="form-control"
                value="{{ old('site_title', $siteTitle) }}"
            >
        </div>

        <div class="mb-3">
            <label for="per_page" class="form-label">Recursos por página</label>
            <input
                id="per_page"
                name="per_page"
                type="number"
                min="1"
                class="form-control"
                value="{{ old('per_page', $perPage) }}"
            >
        </div>

        <div class="mb-3">
            <label for="max_resources_per_user" class="form-label">Máx. recursos por usuario</label>
            <input
                id="max_resources_per_user"
                name="max_resources_per_user"
                type="number"
                min="1"
                class="form-control"
                value="{{ old('max_resources_per_user', $maxResourcesPerUser) }}"
            >
        </div>

        <button class="btn btn-primary">Guardar cambios</button>
    </form>
@endsection
