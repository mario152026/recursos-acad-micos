{{-- resources/views/recursos/crear.blade.php --}}
@extends('layouts.public')
@section('title', 'Subir Recurso')
@section('content')
    <h2>Subir Nuevo Recurso</h2>

    <form method="POST" action="{{ route('recursos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required
                   class="form-control @error('titulo') is-invalid @enderror">
            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select id="categoria_id" name="categoria_id"
                        class="form-select @error('categoria_id') is-invalid @enderror" required>
                    <option value="">Selecciona...</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre_asignatura }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="nivel_id" class="form-label">Nivel Educativo</label>
                <select id="nivel_id" name="nivel_id"
                        class="form-select @error('nivel_id') is-invalid @enderror" required>
                    <option value="">Selecciona...</option>
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}"
                            {{ old('nivel_id') == $nivel->id ? 'selected' : '' }}>
                            {{ $nivel->nombre_nivel }}
                        </option>
                    @endforeach
                </select>
                @error('nivel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo (PDF/JPG/PNG)</label>
            <input type="file" id="archivo" name="archivo" required
                   class="form-control @error('archivo') is-invalid @enderror">
            @error('archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-success">Subir Recurso</button>
    </form>
@endsection
