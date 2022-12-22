<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Zip extends Model
{

    public function compactarProntuario($nome, $pasta)
    {
        set_time_limit(env("TEMPO_DOWNLOAD"));
        $zip = new ZipArchive();

        if (!is_dir("C:/prontuarios")){
            mkdir("C:/prontuarios");
        }

        $arquivoCompac = "C:/prontuarios/$nome.zip";

        if (file_exists("{$arquivoCompac}")) {
            unlink("{$arquivoCompac}");
        }

        $zip->open("{$arquivoCompac}", ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator("{$pasta}"),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen("{$pasta}") + 1);
                // Adiciona os arquivos no pacote Zip.
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        if($this->verificarCompactacao($arquivoCompac)){
            return $arquivoCompac;
        }
    }

    function verificarCompactacao($arquivoCompac)
    {
        if (is_readable($arquivoCompac)) {
            return true;
        }
    }
}
