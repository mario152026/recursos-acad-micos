<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Recurso;

class Reporte extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla (opcional si sigues la convención)
    protected $table = 'reportes';

    // Permitir asignación masiva
    protected $fillable = [
        'user_id',
        'recurso_id',
        'motivo',
        'resuelto',
    ];

    // Usamos created_at / updated_at
    public $timestamps = true;

    /**
     * Relación al usuario que reporta.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación al recurso reportado.
     */
    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'recurso_id');
    }
}
