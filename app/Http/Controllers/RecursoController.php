<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Asignatura;
use App\Models\NivelEducativo;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    /**
     * Mostrar listado general de recursos (público y autenticado).
     * Solo recursos activos.
     */
    public function index(Request $request)
    {
        $query = Recurso::where('activo', true);

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('categoria')) {
            $query->where('id_asignatura', $request->categoria);
        }
        if ($request->filled('nivel')) {
            $query->where('id_nivel', $request->nivel);
        }

        $perPage    = Setting::get('per_page', 9);
        $recursos   = $query->paginate($perPage)->withQueryString();
        $categorias = Asignatura::all();
        $niveles    = NivelEducativo::all();

        return view('recursos.explorar', compact('recursos', 'categorias', 'niveles'));
    }

    /**
     * Mostrar solo los recursos del usuario autenticado.
     * Aquí mostramos TODO (activo o no) porque es su propio panel.
     */
    public function myResources(Request $request)
    {
        $query = Recurso::where('id_usuario', Auth::id());

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('categoria')) {
            $query->where('id_asignatura', $request->categoria);
        }
        if ($request->filled('nivel')) {
            $query->where('id_nivel', $request->nivel);
        }

        $perPage    = Setting::get('per_page', 9);
        $recursos   = $query->paginate($perPage)->withQueryString();
        $categorias = Asignatura::all();
        $niveles    = NivelEducativo::all();

        return view('recursos.mine', compact('recursos', 'categorias', 'niveles'));
    }

    /**
     * Mostrar detalle de un recurso.
     * Solo accesible si está activo.
     */
    public function show(Recurso $recurso)
    {
        if (! $recurso->activo) {
            abort(404);
        }

        return view('recursos.ver', compact('recurso'));
    }

    /**
     * Formulario para crear un recurso.
     */
    public function create()
    {
        $categorias = Asignatura::all();
        $niveles    = NivelEducativo::all();

        return view('recursos.crear', compact('categorias', 'niveles'));
    }

    /**
     * Almacenar un recurso nuevo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|exists:asignaturas,id',
            'nivel_id'     => 'required|exists:niveles_educativos,id',
            // ahora aceptamos mp4, mov y avi y subimos el límite a 20MB
            'archivo'      => 'required|file|mimes:pdf,jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        // Límite de recursos por usuario
        $max   = Setting::get('max_resources_per_user', 10);
        $count = Recurso::where('id_usuario', Auth::id())->count();
        if ($count >= $max) {
            return back()
                ->withInput()
                ->withErrors(['limite' => "Has alcanzado el máximo de {$max} recursos."]);
        }

        $file = $request->file('archivo');
        $path = $file->store('recursos', 'public');
        $tipo = $file->extension();

        $recurso = Recurso::create([
            'titulo'        => $validated['titulo'],
            'descripcion'   => $validated['descripcion'],
            'id_usuario'    => Auth::id(),
            'user_id'       => Auth::id(),
            'id_asignatura' => $validated['categoria_id'],
            'id_nivel'      => $validated['nivel_id'],
            'archivo_url'   => $path,
            'tipo'          => $tipo,
            'activo'        => true,  // aseguramos que empiece activo
        ]);

        return redirect()
            ->route('recursos.show', $recurso)
            ->with('success', 'Recurso subido correctamente.');
    }

    /**
     * Formulario para editar un recurso.
     */
    public function edit(Recurso $recurso)
    {
        $this->authorize('update', $recurso);

        $categorias = Asignatura::all();
        $niveles    = NivelEducativo::all();

        return view('recursos.editar', compact('recurso', 'categorias', 'niveles'));
    }

    /**
     * Actualizar un recurso existente.
     */
    public function update(Request $request, Recurso $recurso)
    {
        $this->authorize('update', $recurso);

        $validated = $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|exists:asignaturas,id',
            'nivel_id'     => 'required|exists:niveles_educativos,id',
            'archivo'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        $updateData = [
            'titulo'        => $validated['titulo'],
            'descripcion'   => $validated['descripcion'],
            'id_asignatura' => $validated['categoria_id'],
            'id_nivel'      => $validated['nivel_id'],
        ];

        if ($request->hasFile('archivo')) {
            Storage::disk('public')->delete($recurso->archivo_url);
            $file = $request->file('archivo');
            $updateData['archivo_url'] = $file->store('recursos', 'public');
            $updateData['tipo']        = $file->extension();
        }

        $recurso->update($updateData);

        return redirect()
            ->route('recursos.show', $recurso)
            ->with('success', 'Recurso actualizado correctamente.');
    }

    /**
     * Borrar un recurso.
     */
    public function destroy(Recurso $recurso)
    {
        $this->authorize('delete', $recurso);

        Storage::disk('public')->delete($recurso->archivo_url);
        $recurso->delete();

        return redirect()
            ->route('recursos.mine')
            ->with('success', 'Recurso eliminado correctamente.');
    }
}
