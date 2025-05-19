<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Asignatura;
use App\Models\NivelEducativo;
use App\Models\ValoracionComentario;

class Recurso extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar masivamente.
     * Añadimos tanto 'id_usuario' como 'user_id'.
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'id_usuario',      // FK real
        'user_id',         // mantenemos para no romper la tabla existente
        'id_asignatura',
        'id_nivel',
        'archivo_url',
        'tipo',
    ];

    /**
     * Relación al usuario (propietario).
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con asignatura.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    /**
     * Relación con nivel educativo.
     */
    public function nivel()
    {
        return $this->belongsTo(NivelEducativo::class, 'id_nivel');
    }

    /**
     * Relación con valoraciones/comentarios.
     */
    public function valoraciones()
    {
        return $this->hasMany(ValoracionComentario::class, 'recurso_id');
    }
}
