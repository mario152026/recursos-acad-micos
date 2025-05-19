<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Recurso;

class ValoracionComentario extends Model
{
    use HasFactory;

    /**
     * Forzamos el nombre de la tabla para que coincida
     * con la migración: valoracion_comentarios
     */
    protected $table = 'valoracion_comentarios';

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'user_id',
        'recurso_id',
        'calificacion',
        'comentario',
    ];

    /**
     * Relación al usuario que hace la valoración.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación al recurso valorado.
     */
    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'recurso_id');
    }
}
