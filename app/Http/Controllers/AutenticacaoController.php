<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AutenticacaoController extends Controller
{

    public function logar(Request $request)
    {
        $usuario = new Usuario();
        if ($usuario->validarUsuario($request) == true) {
            return redirect(route('painel'));
        } else {
            return redirect(route('login'));
        }
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
