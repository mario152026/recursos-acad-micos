<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /** Mostrar formulario de ajustes */
    public function edit()
    {
        return view('admin.settings.edit', [
            'siteTitle'             => Setting::get('site_title'),
            'perPage'               => Setting::get('per_page'),
            'maxResourcesPerUser'   => Setting::get('max_resources_per_user'),
        ]);
    }

    /** Guardar cambios */
    public function update(Request $request)
    {
        $data = $request->validate([
            'site_title'               => 'required|string|max:255',
            'per_page'                 => 'required|integer|min:1',
            'max_resources_per_user'   => 'required|integer|min:1',
        ]);

        Setting::where('key','site_title')
            ->update(['value'=>$data['site_title']]);
        Setting::where('key','per_page')
            ->update(['value'=>$data['per_page']]);
        Setting::where('key','max_resources_per_user')
            ->update(['value'=>$data['max_resources_per_user']]);

        return back()->with('success','Ajustes guardados.');
    }
}
