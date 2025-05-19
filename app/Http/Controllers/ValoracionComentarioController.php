<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\ValoracionComentario;
use Illuminate\Http\Request;

class ValoracionComentarioController extends Controller
{
    public function store(Recurso $recurso, Request $request)
    {
        $data = $request->validate([
            'calificacion' => 'required|integer|between:1,5',
            'comentario'   => 'nullable|string|max:1000',
        ]);

        $data['user_id']    = auth()->id();
        $data['recurso_id'] = $recurso->id;

        ValoracionComentario::create($data);

        return back()->with('success','¡Gracias por tu valoración!');
    }
}
