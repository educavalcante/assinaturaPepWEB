<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $connection = 'fatura';

    protected $fillable = [
        'id', 'nome', 'depto', 'idDepto', 'cpf', 'senha'
    ];

    protected $hidden = [
        'senha'
    ];

    public function validarUsuario($request)
    {
        $dados = $request->all();

        $login = $dados['usuario'];
        $senha = $dados['senha'];
        $senhacrip = Hash::make($senha);

        if (filter_var($login,FILTER_VALIDATE_INT) && strlen($login) <= 8) {
            $usuario = Usuario::where('id', $login)->first();
            if (Auth::check()) {
                session()->flush();
            }
            if ($usuario && Hash::check($usuario->senha, $senhacrip)) {
                Auth::login($usuario);
                return true;
            } else {
                //return redirect(route('login'));
                return false;
            }
        } else {
            return false;
        }
    }
}
