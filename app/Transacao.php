<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transacao extends Model
{
    public function iniciarTransacao($token)
    {
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_PORT => "8080",
            CURLOPT_URL => "http://".env('HOST_ASSINATURA').":".env('PORT_HOST_ASSINATURA')."/signature-service",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"certificate_alias\": \"\",\n\t\"type\": \"PDFSignature\",\n\t\"hash_algorithm\": \"SHA256\",\n\t\"auto_fix_document\": true,\n\t\"signature_settings\": [{\n\t\t\"id\": \"default\",\n\t\t\"contact\": \"123456789\",\n\t\t\"location\": \"Goiânia - GO\",\n\t\t\"reason\": \"Assinatura_Documento\"\n\t}],\n\t\"documents_source\": \"UPLOAD_REFERENCE\"\n}",
            CURLOPT_HTTPHEADER => array(
              "Accept: application/json",
              "Authorization: Bearer ".$token,
              "Content-Type: application/json",
              "cache-control: no-cache"
                ),
            ));

            
            $response = json_decode(curl_exec($curl),true);
            curl_close($curl);

        if(array_key_exists('tcn',$response)){
            $tcn =  $response['tcn'];
            #
            #$result = DB::connection('imagens')->select("SELECT TCN FROM TOKEN
            #WHERE ID = $id and TOKEN = '{$token}' ");
            #foreach($result as $row){
            #    $verificaTcn = $row->TCN;
            #}
#
            #if($verificaTcn){
            #    DB::connection('imagens')->insert("INSERT INTO TOKEN (TOKEN,TCN,DATA) VALUES ('".$token."','{$tcn}',CURRENT_TIME)");
            #    
            #    $result = DB::connection('imagens')->select("SELECT ID 
            #    FROM TOKEN
            #    WHERE TCN = '{$tcn}' and TOKEN = '{$token}' ");
            #    foreach($result as $row){
            #        session()->put('id',$row->ID);
            #    }
            #}else{
            #    DB::connection("imagens")->update("UPDATE TOKEN SET TCN = '".$tcn."'
            #    WHERE ID = $id ");
            #}
            #echo $response['tcn'];
            // $rowToken = DB::connection("fatura")->select("SELECT FIRST 1 TOKEN 
            // FROM TOKEN
            // WHERE CPF = '78744750544' ORDER BY DATA DESC;");
            session()->put('tcn',$tcn);
            // dd(session()->get('token'));
            
            return true;
        }else{
            return false;
        }
    }
}
