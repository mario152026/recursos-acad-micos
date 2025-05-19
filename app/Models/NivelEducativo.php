<?php
// app/Models/NivelEducativo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    use HasFactory;

    // FORZAMOS el nombre correcto de la tabla:
    protected $table = 'niveles_educativos';

    // Campos rellenables (opcional, pero recomendable)
    protected $fillable = ['nombre_nivel'];

    /**
     * Un nivel puede tener muchos recursos.
     */
    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'id_nivel');
    }
}
