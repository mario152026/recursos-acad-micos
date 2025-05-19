@extends('layouts.admin')

@section('title','Reportes — Admin')

@section('content')
    <h1 class="mb-4">Gestión de Reportes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($reportes->isEmpty())
        <div class="alert alert-info">No hay reportes pendientes.</div>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Recurso</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reportes as $rep)
                <tr>
                    <td>{{ $rep->id }}</td>
                    <td>{{ optional($rep->usuario)->name ?? $rep->user_id }}</td>
                    <td>
                        #{{ $rep->recurso->id }} {{ $rep->recurso->titulo }}
                        <a
                            href="{{ route('recursos.show', $rep->recurso) }}"
                            class="btn btn-sm btn-success"
                        >
                            Ver
                        </a>
                    </td>
                    <td>{{ $rep->motivo }}</td>
                    <td>{{ $rep->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-end">
                        {{-- Desestimar reporte --}}
                        <form
                            action="{{ route('admin.reportes.resuelto', $rep) }}"
                            method="POST"
                            class="d-inline"
                        >
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-secondary">
                                Desestimar
                            </button>
                        </form>

                        {{-- Eliminar reporte --}}
                        <form
                            action="{{ route('admin.reportes.destroy', $rep) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar este reporte?')"
                            class="d-inline"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $reportes->links() }}
    @endif
@endsection
