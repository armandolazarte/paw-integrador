<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function index(string $query)
    {
        return DB::table('users')->where('name', 'LIKE', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->paginate(7);
    }

    public static function guardar(Http\Requests\UsuarioFormRequest $request)
    {
        $usuario = new self;
        $usuario->name = $request->get('name');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->save();
    }

    public static function getRoles()
    {
        $roles=DB::table('roles')->get();
    }

    public static function actualizar(Http\Requests\UsuarioFormRequest $request, $id)
    {
        $usuario = self::findOrFail($id);
        $usuario->name = $request->get('name');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->update();
    }

    public static function changeRole(\Illuminate\Http\Request $request)
    {
        $user= self::findOrFail($request->input('id'));
        $user->assignRole($request->input('role'));
        $rol=$request->input('role');
        echo $rol;
    }
}
