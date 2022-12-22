<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\Http\Requests\ArquivoRequest;
use App\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;


class ArquivoController extends Controller
{

    public function retirarDoc(ArquivoRequest $request)
    {
        $arquivo = new Arquivo();
        $retiraDocumento = $arquivo->retirarDoc($request['idDoc'],$request['justificativa']);
        if($retiraDocumento){
            $msg = array([
               "status" => true,
                "msg" => 'Documento removido'
            ]);
            return response()->json($msg,200);
        }
    }

    public function verificarBird()
    {
        $bird = $_POST['codigo'];
        $arquivo = new Arquivo();

        $status = $arquivo->verificarBird($bird);

        switch ($status) {
            case (1):
                $msg = array([
                    "status" => true,
                    "msg" => "Autenticação realizada com sucesso !",
                ]);
                return response()->json($msg, 200);
                break;
            case (2):
                $msg = array([
                    "status" => false,
                    "msg" => "Bird inválido !",
                ]);
                return response()->json($msg, 200);
                break;
            case (3):
                $msg = array([
                    "status" => false,
                    "msg" => "Usuário não possui CPF cadastrado no sistema. Por favor ! Adicione ",
                ]);
                return response()->json($msg, 200);
                break;
        }
    }

    public function assinarDocumento($numeroArquivo)
    {
        $ip = request()->getClientIp();
        $uri = request()->getUri();

        session()->put('uriCliente', $uri);
        session()->put('ipCliente', $ip);

        if (session()->get('token' . Auth::user()->id)) {
            if (Auth::user()->cpf) {
                if (filter_var($numeroArquivo, FILTER_VALIDATE_INT)) {
                    $arquivo = new Arquivo();
                    if ($arquivo->assinarDocumento($numeroArquivo) == true) {
                        $msg = array([
                            "status" => true,
                            "msg" => 'Arquivo Assinado !'
                        ]);
                        return response()->json($msg, 200);
                    } else {
                        $msg = array([
                            "status" => false,
                            "msg" => session()->get('msg')
                        ]);
                        return response()->json($msg, 200);
                    }
                }
            } else {
                $msg = array([
                    "status" => false,
                    "msg" => "Usuario não possui cpf cadastrado no sistema !"
                ]);

                return response()->json($msg, 200);
            }
        } else {
            $msg = array([
                "status" => false,
                "msg" => "É necessario o bird id para a assinatura !"
            ]);

            return response()->json($msg, 200);
        }
    }


    public function baixarArquivo($numeroArquivo)
    {
        //        file_put_contents("C:\\laudosPdf\\{$arquivo}.pdf", fopen(env('APP_URL')."/assinatura/public/buscar/{$arquivo}", 'r'));
        if (filter_var($numeroArquivo, FILTER_VALIDATE_INT)) {
            $arquivo = new Arquivo();
            $arquivo->baixarArquivo($numeroArquivo);
        }
    }

    public function visualizarArquivo($numeroArquivo)
    {
        if (filter_var($numeroArquivo, FILTER_VALIDATE_INT)) {
            $arquivo = new Arquivo();
            $pdf = $arquivo->buscarArquivo($numeroArquivo);

            return response($pdf)
                ->header('Content-type', 'application/pdf')
                ->header('X-Header-One', 'Header Value')
                ->header('X-Header-Two', 'Header Value');
        }
    }

    public function download($numeroArquivo)
    {
        if (filter_var($numeroArquivo, FILTER_VALIDATE_INT)) {
            $arquivo = new Arquivo();
            $arquivo->download($numeroArquivo);
        }
    }

    public function listarArquivo(Request $request)
    {
        $arquivo = new Arquivo();
        $listaArquivos = $arquivo->arquivosPendentes($request);
        return response()->json($listaArquivos, 200);
    }

    public function listarArquivosAssinados(Request $request)
    {
        $arquivo = new Arquivo();
        $listaArquivosAssinados = $arquivo->arquivosAssinados($request);
        return response()->json($listaArquivosAssinados, 200);
    }

    public function baixarProntuario()
    {

        if (filter_var($_POST['cps'], FILTER_VALIDATE_INT)) {
            $arquivo = new Arquivo();
            $prontuario = $arquivo->baixarProntuario($_POST['cps']);
            if($prontuario == false){
                return view('downloadProntuario');
            }else{
                return response()->download($prontuario);
            }
        }
    }

    public function buscaProntuario(Request $request)
    {
        $dados = $request->all();
        if (filter_var($dados['cps'], FILTER_VALIDATE_INT)) {
            $arquivo = new Arquivo();
            $statusProntuarios = $arquivo->situacaoProntuario($dados['cps']);
            return view('verificaArquivos', compact('statusProntuarios', $statusProntuarios));
        }
    }
}
