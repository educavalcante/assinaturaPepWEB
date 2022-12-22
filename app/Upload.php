<?php

namespace App;

use CURLFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Upload extends Model
{
    public function uploadArquivo($tcn, $caminho)
    {
        set_time_limit(300);

        $curlFILE = curl_init();
        curl_setopt_array($curlFILE, array(
            CURLOPT_URL => "http://".env('HOST_ASSINATURA').":".env('PORT_HOST_ASSINATURA')."/file-transfer/$tcn/eot/default",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer supersecret"
            ),

            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => array(
                // 'document[0]' => new CURLFile ("{$arquivo}")
                'document[0]' => new CURLFile("C:/laudosPdf/" . $caminho . ".pdf"),
                #                'document[0]' => new CURLFile ("C:/xampp/htdocs/laudo/pdf.pdf")
            ),

            CURLOPT_RETURNTRANSFER => 1,
            // CURLOPT_NOPROGRESS => false,s
            CURLOPT_COOKIESESSION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,

        ));

        $response = curl_exec($curlFILE);
        curl_close($curlFILE);

        if ($response == true) {

            $cpf = Auth::user()->cpf;
            $usuario = Auth::user()->id;

            $token = session()->get('token' . Auth::user()->id);

            $ipCliente = session()->get('ipCliente');
            $urlCliente = session()->get('uriCliente');
            $linkArquivo = "http://".env('HOST_ASSINATURA').":".env('PORT_HOST_ASSINATURA')."/file-transfer/$tcn/0";
            $status = [];

            do {
                $h = get_headers($linkArquivo);
                $status = array();
                preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0], $status);
            } while ($status[1] != "200");


            if ($status[1] == "200") {

                DB::connection('imagens')->insert("INSERT INTO TOKEN (TOKEN,TCN,CPF,IPCLIENTE,URLACESSADA,LINKARQUIVOASSINADO,ARQUIVO,DATA,USUARIO)
                VALUES ('{$token}','{$tcn}','{$cpf}','{$ipCliente}','{$urlCliente}','{$linkArquivo}',$caminho,CURRENT_TIME,$usuario) ");

                $results = DB::connection('imagens')->select("SELECT ID,TCN,ARQUIVO, extract(month from data) mes, extract(year from data) ano FROM TOKEN where TCN = '{$tcn}' ");

                foreach ($results as $result) {
                    $id = $result->ID;
                    $ano = $result->ANO; // cria pasta com o ano
                    $mes = $result->MES; // cria pasta com o mes
                    $p1 = $result->ID; // cria pasta com o id
                    $p2 = $result->TCN; // cria a pasta2 com o
                    $nomeDoArquivo = $result->ARQUIVO;
                    if (!is_dir("C:\\ArquivosAssinados"))
                        mkdir("C:\\ArquivosAssinados");
            
                    if (!is_dir("C:\\ArquivosAssinados\\$ano"))
                        mkdir("C:\\ArquivosAssinados\\$ano", true);
                    if (!is_dir("C:\\ArquivosAssinados\\$ano\\$mes"))
                        mkdir("C:\\ArquivosAssinados\\$ano\\$mes", true);
                    mkdir("C:\\ArquivosAssinados\\$ano\\$mes\\$p1", true);
                    mkdir("C:\\ArquivosAssinados\\$ano\\$mes\\$p1\\$p2", true);
                    $diretorio = "C:\\ArquivosAssinados\\$ano\\$mes\\$p1\\$p2\\$nomeDoArquivo.pdf";
                    file_put_contents($diretorio, fopen("http://".env('HOST_ASSINATURA').":".env('PORT_HOST_ASSINATURA')."/file-transfer/$tcn/0", 'r'));
                }
                DB::connection('imagens')->update("UPDATE TOKEN SET DIRETORIO = '{$diretorio}'
                WHERE ID = $id ");

                return true;
            } else {
                return session()->put('msg', $h[0]);
            }
        }
    }
}
