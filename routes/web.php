<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('login', function () {
    return view('index');
})->name('login');


Route::get('/', function () {
    return view('index');
});

Route::get('/logout', 'AutenticacaoController@logout')->name('logout');
Route::post('logar', 'AutenticacaoController@logar')->name('logar');
Route::get('buscar/{numeroArquivo}', 'ArquivoController@visualizarArquivo')->name('visualizar');

Route::middleware(['auth'])->group(function () {
// rotas para views ==========
    Route::get('painel', function () {
        return view('painel');
    })->name('painel');

    Route::get('verifica-prontuario', function () {
        return view('verificaArquivos');
    })->name('verificar');

    Route::get('prontuario-download', function () {
        return view('downloadProntuario');
    })->name('baixar_prontuario');

    Route::get('docPendentes', function () {
        return view('arquivosPendentes');
    })->name('documentosPendentes');

    Route::get('docAssinados', function () {
        return view('arquivosAssinados');
    })->name('documentosAssinados');
// fim rotas para views
    Route::post('arquivo-retiraDoc', 'ArquivoController@retirarDoc')->name('retiraDoc');
    Route::post('baixar-prontuario', 'ArquivoController@baixarProntuario')->name('baixar-prontuario');
//    Route::get('baixar/{arquivo}', 'ArquivoController@baixarArquivo');
    Route::post('verificarProntuario', 'ArquivoController@buscaProntuario')->name('buscaProntuario');
    Route::post('bird', 'ArquivoController@verificarBird')->name('verificaBird');
    Route::get('assinar/{cpf}/{senha}/{idTabela}/{caminho}', 'ArquivoController@assinar');
    Route::get('assinarDocumento/{numeroArquivo}', 'ArquivoController@assinarDocumento')->name('assinar');
    Route::get('download/{numeroArquivo}', 'ArquivoController@download')->name('download');
    Route::post('lista', 'ArquivoController@listarArquivo')->name('listarDocumentos');
    Route::post('assinados', 'ArquivoController@listarArquivosAssinados')->name('arquivosAssinados');
});
