<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key','value'];

    /**
     * Obtiene un setting por clave o devuelve un default.
     */
    public static function get(string $key, $default = null)
    {
        $val = static::where('key',$key)->value('value');
        return $val !== null ? $val : $default;
    }
}
