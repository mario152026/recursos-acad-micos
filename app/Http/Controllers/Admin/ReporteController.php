<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Mostrar solo los reportes pendientes (resuelto = false).
     */
    public function index(Request $request)
    {
        $reportes = Reporte::where('resuelto', false)
            ->with(['usuario', 'recurso'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.reportes.index', compact('reportes'));
    }

    /**
     * Marcar un reporte como resuelto (desestimado).
     */
    public function markResolved(Reporte $reporte)
    {
        $reporte->update(['resuelto' => true]);

        return back()->with('success', 'Reporte desestimado correctamente.');
    }

    /**
     * Eliminar un reporte y el recurso asociado.
     */
    public function destroy(Reporte $reporte)
    {
        // Si existe el recurso asociado, borrar su archivo y registro
        if ($reporte->recurso) {
            $archivo = $reporte->recurso->archivo_url;

            if (Storage::disk('public')->exists($archivo)) {
                Storage::disk('public')->delete($archivo);
            }

            $reporte->recurso->delete();
        }

        // Borrar el propio reporte
        $reporte->delete();

        return back()->with('success', 'Reporte y recurso asociado eliminados correctamente.');
    }
}
