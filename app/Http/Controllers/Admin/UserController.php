<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // Solo administradores pueden acceder
        $this->middleware('admin');
    }

    /**
     * Listado de usuarios (paginado).
     */
    public function index()
    {
        $usuarios = User::orderByDesc('created_at')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Alterna el estado activo/inactivo del usuario.
     */
    public function toggleActivo(User $usuario)
    {
        // Impedir que un admin se desactive a sí mismo
        if (auth()->id() === $usuario->id) {
            return back()->with('error', 'No puedes desactivarte a ti mismo.');
        }

        $usuario->activo = ! $usuario->activo;
        $usuario->save();

        return back()->with('success', 'Estado de usuario actualizado.');
    }

    /**
     * Cambia el rol del usuario (1=admin, 2=user).
     */
    public function setRole(Request $request, User $usuario)
    {
        $data = $request->validate([
            'role_id' => 'required|in:1,2',
        ]);

        // Impedir que un admin cambie su propio rol
        if (auth()->id() === $usuario->id) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $usuario->role_id = $data['role_id'];
        $usuario->save();

        return back()->with('success', 'Rol de usuario actualizado.');
    }

    /**
     * Elimina un usuario de forma permanente.
     */
    public function destroy(User $usuario)
    {
        // Impedir que un admin elimine su propia cuenta
        if (auth()->id() === $usuario->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
