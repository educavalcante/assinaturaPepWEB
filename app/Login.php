<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    public function validarAcesso($cpf, $senha)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://".env('HOST_ASSINATURA').":".env('PORT_HOST_ASSINATURA')."/oauth",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\"client_id\":\"".env('CLIENT_ID')."\",\n\"client_secret\":\"".env('CLIENT_SECRET')."\",\n\"username\":\"" . $cpf . "\",\n\"password\":\"" . $senha . "\",\n\"grant_type\":\"password\",\n\"scope\":\"signature_session\",\n\"lifetime\": 2592000\n}\n\n\n",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Postman-Token: b05c1dac-0087-464e-8864-1b9340bc5f73",
                "cache-control: no-cache"
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (array_key_exists('access_token', $response)) {
            $token = $response['access_token'];

            session()->put('token'.Auth::user()->id, $token);

            return true;
        } else {
            return false;
        }
    }
}
