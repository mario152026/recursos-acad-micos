<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Reporte;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function store(Recurso $recurso, Request $request)
    {
        $data = $request->validate([
            'motivo' => 'required|string|max:255',
        ]);

        $data['user_id']    = auth()->id();
        $data['recurso_id'] = $recurso->id;

        Reporte::create($data);

        return back()->with('success','Contenido reportado, gracias.');
    }
}
