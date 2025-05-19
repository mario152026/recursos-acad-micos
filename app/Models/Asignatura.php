<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recurso;        // ¡Importa Recurso para la relación!

class Asignatura extends Model
{
    use HasFactory;

    // Opcional: explícita el nombre de la tabla si no sigue la convención
    // protected $table = 'asignaturas';

    // Rellenables
    protected $fillable = ['nombre_asignatura'];

    /**
     * Una asignatura puede tener muchos recursos.
     * La FK en la tabla `recursos` se llama `id_asignatura`.
     */
    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'id_asignatura');
    }
}
