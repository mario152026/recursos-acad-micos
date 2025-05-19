{{-- resources/views/recursos/editar.blade.php --}}
@extends('layouts.public')
@section('title', 'Editar Recurso')
@section('content')
    <h2>Editar Recurso</h2>

    <form method="POST" action="{{ route('recursos.update', $recurso) }}" enctype="multipart/form-data">
        @csrf @method('PATCH')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo"
                   value="{{ old('titulo', $recurso->titulo) }}" required
                   class="form-control @error('titulo') is-invalid @enderror">
            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $recurso->descripcion) }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select id="categoria_id" name="categoria_id"
                        class="form-select @error('categoria_id') is-invalid @enderror" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoria_id', $recurso->id_asignatura) == $cat->id ? 'selected' : '' }}>
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
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}"
                            {{ old('nivel_id', $recurso->id_nivel) == $nivel->id ? 'selected' : '' }}>
                            {{ $nivel->nombre_nivel }}
                        </option>
                    @endforeach
                </select>
                @error('nivel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Archivo Actual</label>
            <p>
                <a href="{{ asset('storage/' . $recurso->archivo_url) }}" target="_blank">
                    Ver/Descargar archivo
                </a>
            </p>
            <label for="archivo" class="form-label">Cambiar Archivo (opcional)</label>
            <input type="file" id="archivo" name="archivo"
                   class="form-control @error('archivo') is-invalid @enderror">
            @error('archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Recurso</button>
    </form>
@endsection
