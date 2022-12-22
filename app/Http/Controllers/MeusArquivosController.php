<?php

namespace App\Http\Controllers;

use App\Arquivo;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeusArquivosController extends Controller
{
    public function meusDocumentos()
    {
        return view('meusArquivos');
    }

    public function listarArquivo($request)
    {
        $usuario = Auth::user()->id;

        $columns = array(
            0 => "data_criacao"
        );

        $requestData = $request->all();

        $start = $requestData['start'];
        $lenght = $requestData['length'];
        // ===================================

        // faz a consulta no banco para pegar a quantidade de registros
        $requestData['search']['value'] = str_replace("", "", preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($requestData['search']['value']))));
        $requestData['search']['value'] = str_replace("/", ".", $requestData['search']['value']);
        $dataTeste = DateTime::createFromFormat('d.m.Y', $requestData['search']['value']);

        $sql = "SELECT * FROM LISTAR_DOCUMENTOS
        WHERE USUARIO = $usuario ";
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( PACIENTE LIKE UPPER('" . $requestData['search']['value'] . "%') "; // PESQUISA PELO NOME DO PACIENTE
            $sql .= " OR CPS LIKE '" . $requestData['search']['value'] . "%' "; // PESQUISA PELO NOME DO PACIENTE
            if ($dataTeste && $dataTeste->format('d.m.Y') === $requestData['search']['value']) {
                $sql .= " OR DATA_CRIACAO = '" . $requestData['search']['value'] . "' )"; // PESQUISA PELO NOME DO PACIENTE
            } else {
                $sql .= " OR DATA_CRIACAO = null)"; // PESQUISA PELO NOME DO PACIENTE
            }
        }

        $sql .= " ORDER BY " . $columns[$requestData["order"][0]["column"]] . " DESC";
        $exames = DB::connection('imagens')->select($sql);
        $totalDeRegistros = count($exames);
        // ===================================================================================
        if (!empty($requestData["search"]["value"])) {
            $sql = "SELECT FIRST $lenght SKIP $start *
            FROM LISTAR_DOCUMENTOS
            WHERE USUARIO = $usuario ";
            $sql .= " AND ( PACIENTE LIKE UPPER('" . $requestData['search']['value'] . "%') "; // PESQUISA PELO NOME DO PACIENTE
            $sql .= " OR CPS LIKE '" . $requestData['search']['value'] . "%' "; // PESQUISA PELO NOME DO PACIENTE

            if ($dataTeste && $dataTeste->format('d.m.Y') === $requestData['search']['value']) {
                $sql .= " OR DATA_CRIACAO = '" . $requestData['search']['value'] . "' )"; // PESQUISA PELO NOME DO PACIENTE
            } else {
                $sql .= " OR DATA_CRIACAO = null )"; // PESQUISA PELO NOME DO PACIENTE
            }

            $sql .= " ORDER BY " . $columns[$requestData["order"][0]["column"]] . " DESC";

            $pacientes = DB::connection('imagens')->select($sql);
        } else {

            $sql = "SELECT FIRST $lenght SKIP $start *
            FROM LISTAR_DOCUMENTOS
            WHERE USUARIO = $usuario ";

            $sql .= " ORDER BY " . $columns[$requestData["order"][0]["column"]] . " DESC";
            // $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . "";
            $pacientes = DB::connection('imagens')->select($sql);
        }

        foreach ($pacientes as $dados) {

            if (session()->exists('token')) {
                $assinar = "<button onclick='assinar({$dados->NUMERO});this.disabled=true' title='Assinar Documento' id='enviar' class='btn btn-primary'><span><i class='fa fa-check'></i></span></button>";
            } else {
                $assinar = "<td><button type='button' class='btn' data-toggle='modal' data-target='#exampleModal'><span><i class='fa fa-check'></i></span></button></td>";
            }

            if ($dados->DATA) {
                $dataAssinatura = date('d/m/Y', strtotime($dados->DATA));

                $baixar = "<a class='btn' title='Baixar Documento Assinado' target='_blank'><span><i class='fa fa-cloud-download'></i></span></a>";
                // $baixar = "<a  id='' class='btn' title='Baixar Documento Assinado' target='_blank' href='".route('download',$dados->NUMERO)."'><span><i class='fa fa-cloud-download'></i></span></a>";
            } else {
                $dataAssinatura = ' ';
                $baixar = "<a class='btn btn-warning' id='pendente' title='Pendente' ><span><i class='fa fa-exclamation-circle'></i></span></a>";
            }

            $data[] = array(

                "documentos" => $dados->APELIDO,
                "cps" => $dados->CPS,
                "paciente" => $dados->PACIENTE,
                "visualizar" => "<a  id='visualizar' class='btn' title='Visualizar Documento' target='_blank' href='" . route('visualizar', $dados->NUMERO) . "'><span><i class='fa fa-eye'></i></span></a>",
                "criado" => date('d/m/Y', strtotime($dados->DATA_CRIACAO)),
                "status" => $baixar,
                "dataAssinatura" => $dataAssinatura,
                "assinar" => $assinar
            );
        }

        if ($data == null) {
            $data = [];
        }

        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($totalDeRegistros),  //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($totalDeRegistros), //Total de registros quando houver pesquisa
            "data" => $data   //Array de dados completo dos dados retornados da tabela
        );

        // echo json_encode($json_data);  //envia os em formato json para a pagina onde estar a tabela

        return response()->json($json_data, 200);
    }
}
