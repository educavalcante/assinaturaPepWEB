<?php

namespace App;

use DateTime;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class Arquivo extends Model
{

    public function verificarBird($bird)
    {
        $login = new Login();
        $cpf = Auth::user()->cpf;

        if ($cpf != null) {
            if ($login->validarAcesso($cpf, $bird) == true) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function retirarDoc($idDoc, $justificativa)
    {
        $usuario = Auth::user()->id;
        $retiraDoc = DB::connection('imagens')->update("update imagens set reconhece = 'N',justificativa = '{$justificativa}'
        where numero = $idDoc and user1 = $usuario ");
        if ($retiraDoc == true) {
            return true;
        } else {
            return false;
        }
    }

    public function assinarDocumento($numeroArquivo)
    {
        $arquivo = $numeroArquivo;
        $transacao = new Transacao();
        $upload = new Upload();

        $this->baixarArquivo($numeroArquivo);
        if ($transacao->iniciarTransacao(session()->get('token' . Auth::user()->id)) == true) {
            if ($upload->uploadArquivo(session()->get('tcn'), $arquivo) == true) {
                return true;
            }
        }
    }

    public function baixarArquivo($numeroArquivo)
    {
        if (!is_dir("C:\\laudosPdf")) {
            mkdir("C:\\laudosPdf");
        }

        file_put_contents("C:\\laudosPdf\\{$numeroArquivo}.pdf", fopen(route("visualizar",$numeroArquivo), 'r'));
    }

    public function buscarArquivo($numeroArquivo)
    {
        $arquivos = DB::connection('imagens')->select("SELECT IMAGEM FROM IMAGENS
        WHERE NUMERO = $numeroArquivo");

        foreach ($arquivos as $arquivo) {
            $pdf = $arquivo->IMAGEM;
        }

        return $pdf;
        //        return response($pdf)
        //            ->header('Content-type', 'application/pdf')
        //            ->header('X-Header-One', 'Header Value')
        //            ->header('X-Header-Two', 'Header Value');
    }

    public function download($numeroArquivo)
    {
        $links = DB::connection('imagens')->select("SELECT LINKARQUIVOASSINADO AS URL FROM TOKEN
        WHERE ARQUIVO = {$numeroArquivo} ");

        foreach ($links as $link) {
            $url = $link->URL;
        }

        $headers = array(
            'Content-Type: ","application/pdf',
        );

        header("Content-Type: ", "application/pdf");
        return response(readfile($url));
    }

    public function arquivosPendentes($request)
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

            if (session()->exists('token' . Auth::user()->id)) {
                $assinar = "<button onclick='assinar({$dados->NUMERO});this.disabled=true' title='Assinar Documento' id='enviar' class='btn btn-primary'><span><i class='fa fa-check'></i></span></button>";
            } else {
                $assinar = "<td><button type='button' class='btn' title='Validar Bird' data-toggle='modal' data-target='#exampleModal'><span><i class='fa fa-check'></i></span></button></td>";
            }

            if ($dados->DATA) {
                $dataAssinatura = date('d/m/Y H:i', strtotime($dados->DATA));

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
                "assinar" => $assinar,
                "retiraDocumento" => "<td><button onclick='modalRetiraDoc($dados->NUMERO)' id='btnRetirarDoc' class='btn btn-danger' title='Retirar Documento' data-toggle='modal' data-target='#modalRetiraDocumento'><span><i class='fa fa-close'></i></span></button></td>"

            );
        }

        if (empty($data)) {
            $data = [];
        }

        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($totalDeRegistros),  //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($totalDeRegistros), //Total de registros quando houver pesquisa
            "data" => $data   //Array de dados completo dos dados retornados da tabela
        );
        return $json_data;
    }

    public function arquivosAssinados($request)
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

        $sql = "SELECT * FROM DOCUMENTOS_ASSINADOS
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
            FROM DOCUMENTOS_ASSINADOS
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
            FROM DOCUMENTOS_ASSINADOS
            WHERE USUARIO = $usuario ";

            $sql .= " ORDER BY " . $columns[$requestData["order"][0]["column"]] . " DESC";
            // $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . "";
            $pacientes = DB::connection('imagens')->select($sql);
        }

        foreach ($pacientes as $dados) {

            (env('DOWNLOAD_ARQUIVO_ASSINADO') == true) ? $baixar = "<a  id='' class='btn' title='Baixar Documento Assinado' target='_blank' href='" . route('download', $dados->NUMERO) . "'><span><i class='fa fa-cloud-download'></i></span></a>"
                :
                $baixar = "<a class='btn' id='bloqueado' title='Download não estar liberado' ><span><i class='fa fa-cloud-download'></i></span></a>";


            $data[] = array(

                "documentos" => $dados->APELIDO,
                "cps" => $dados->CPS,
                "paciente" => $dados->PACIENTE,
                "visualizar" => "<a  id='visualizar' class='btn' title='Visualizar Documento' target='_blank' href='" . route('visualizar', $dados->NUMERO) . "'><span><i class='fa fa-eye'></i></span></a>",
                "criado" => date('d/m/Y', strtotime($dados->DATA_CRIACAO)),
                "status" => $baixar,
                "dataAssinatura" => date('d/m/Y H:i', strtotime($dados->DATA))
            );
        }

        if (empty($data)) {
            $data = [];
        }

        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($totalDeRegistros),  //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($totalDeRegistros), //Total de registros quando houver pesquisa
            "data" => $data   //Array de dados completo dos dados retornados da tabela
        );
        return $json_data;
    }

    public function situacaoProntuario($cps)
    {
        $arquivospendentes = DB::connection('imagens')->select("SELECT * FROM ARQUIVOS_PACIENTES_PENDENTES($cps)");
        $arquivosAss = DB::connection('imagens')->select("SELECT * FROM ARQUIVOS_ASSINADOS($cps)");
        $quantArquivosPen = DB::connection('imagens')->select("SELECT * FROM ARQUIVOS_PENDENTES_QUANT($cps)");
        $situacaoProntuario[] = array(
            'listaArquivoPendentes' => $arquivospendentes,
            'quantPendentes' => $quantArquivosPen,
            'quantAssinados' => $arquivosAss
        );
        return $situacaoProntuario;
    }

    public function baixarProntuario($cps)
    {
        try {
            $prontuarios = DB::connection('imagens')->select("select * from prontuario_assinados($cps)");
            $prontuariosNaoAssinados = DB::connection('imagens')->select("select * from prontuario_pendentes($cps)");
        } catch (Exception $e) {
            //echo $e->getMessage();
        }
        if (empty($prontuarios)) {
            session()->put("error", "Cps não possui arquivos para download !");
            return false;
        }
        if (!is_dir("C:\\prontuarios"))
            mkdir("C:\\prontuarios");

        $diretorio = "C:/prontuarios/{$cps}";
        $dirAssinados = "{$diretorio}/assinados";
        $dirPendentes = "{$diretorio}/nao_assinados";

        $this->verificaPastas($cps);
        if (!empty($prontuariosNaoAssinados)) {
            mkdir("{$dirPendentes}", "0777", true);
            foreach ($prontuariosNaoAssinados as $prontuariosNaoAssinado) {
                file_put_contents("{$dirPendentes}/{$prontuariosNaoAssinado->NOME}.pdf", fopen(env('APP_URL')."/assinatura/buscar/{$prontuariosNaoAssinado->NUMERO}", 'r'));
            }
        }
        if (!empty($prontuarios)) {
            mkdir("{$dirAssinados}", "0777", true);
            foreach ($prontuarios as $prontuario) {
                copy("{$prontuario->DIRETORIO}", "{$dirAssinados}/{$prontuario->NOME} {$prontuario->ID}.pdf");
            }
        }
        $zip = new Zip();
        $prontuarioCompac = $zip->compactarProntuario("{$cps}", "C:/prontuarios/{$cps}");
        return $prontuarioCompac;
    }

    public function verificaPastas($cps)
    {
        if (file_exists("C:/prontuarios/{$cps}")) {

            if (file_exists("C:/prontuarios/{$cps}/assinados")) {
                $handle = opendir("C:/prontuarios/{$cps}/assinados");
                while ($arquivos = readdir($handle)) {
                    if ($arquivos <> "." && $arquivos <> "..") {
                        unlink("C:/prontuarios/{$cps}/assinados/{$arquivos}");
                    }
                }
                closedir($handle);
                rmdir("C:/prontuarios/{$cps}/assinados");
            }
            if (file_exists("C:/prontuarios/{$cps}/nao_assinados")) {
                $handle = opendir("C:/prontuarios/{$cps}/nao_assinados");
                while ($arquivos = readdir($handle)) {
                    if ($arquivos <> "." && $arquivos <> "..") {
                        unlink("C:/prontuarios/{$cps}/nao_assinados/{$arquivos}");
                    }
                }
                closedir($handle);
                rmdir("C:/prontuarios/{$cps}/nao_assinados");
            }
            rmdir("C:/prontuarios/{$cps}");
        }
    }
}
