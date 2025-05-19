<?php
namespace App\Policies;

use App\Models\Recurso;
use App\Models\User;

class RecursoPolicy
{
    public function view(User $user, Recurso $recurso): bool
    {
        // Si quieres que cualquiera vea el detalle, devuelve true:
        return true;
    }

    public function update(User $user, Recurso $recurso): bool
    {
        // El dueño o el admin (role_id = 1) pueden editar
        return $user->id === $recurso->user_id || $user->role_id === 1;
    }

    public function delete(User $user, Recurso $recurso): bool
    {
        // Igual para borrar
        return $user->id === $recurso->user_id || $user->role_id === 1;
    }
}
