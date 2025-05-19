<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recurso;
use App\Models\Asignatura;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    public function __construct()
    {
        // Solo administradores
        $this->middleware('admin');
    }

    /**
     * Mostrar el listado de recursos con filtros opcionales.
     */
    public function index(Request $request)
    {
        // Arrancamos la query incluyendo relaciones
        $query = Recurso::with(['usuario', 'asignatura', 'nivel']);

        // Filtro por título (search)
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%'.$request->search.'%');
        }

        // Filtro por asignatura (categoria)
        if ($request->filled('categoria')) {
            $query->where('id_asignatura', $request->categoria);
        }

        // Filtro por nivel educativo
        if ($request->filled('nivel')) {
            $query->where('id_nivel', $request->nivel);
        }

        // Paginamos y mantenemos query string
        $recursos   = $query->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // Datos para los dropdowns de filtro
        $categorias = Asignatura::all();
        $niveles    = NivelEducativo::all();

        return view('admin.recursos.index', compact('recursos', 'categorias', 'niveles'));
    }

    /**
     * Eliminar un recurso (y su archivo en disco).
     */
    public function destroy(Recurso $recurso)
    {
        if (Storage::disk('public')->exists($recurso->archivo_url)) {
            Storage::disk('public')->delete($recurso->archivo_url);
        }

        $recurso->delete();

        return back()->with('success', 'Recurso eliminado correctamente.');
    }

    /**
     * Alternar el estado 'activo' de un recurso.
     */
    public function toggleActivo(Recurso $recurso)
    {
        $recurso->activo = ! $recurso->activo;
        $recurso->save();

        return back()->with('success', 'Estado del recurso actualizado.');
    }
}
