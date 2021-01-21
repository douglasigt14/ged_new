<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MyLogin;
use App\Http\Middleware\MyAuth;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Setores;
use App\Http\Controllers\Fluxos;
use App\Http\Controllers\Funcionarios;
use App\Http\Controllers\Processos;
use App\Http\Controllers\Passos;
use App\Http\Controllers\Status;
use App\Http\Controllers\Documentos;
use App\Http\Controllers\Anexos_Obs;
use App\Http\Controllers\HistMov;
use App\Http\Controllers\Config;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(MyAuth::class)->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    
    Route::get('/documentos/{mostrar_finalizado?}/{mostrar_outros_setores?}', [Documentos::class, 'index']);
    Route::post('/documentos', [Documentos::class, 'inserir']);
    Route::delete('/documentos', [Documentos::class, 'deletar']);
    Route::patch('/documentos', [Documentos::class, 'alterar_status']);


    Route::get('/setores', [Setores::class, 'index']);
    Route::post('/setores', [Setores::class, 'inserir']);
    Route::delete('/setores', [Setores::class, 'deletar']);
    Route::put('/setores', [Setores::class, 'editar']);

    Route::get('/funcionarios', [Funcionarios::class, 'index']);
    Route::post('/funcionarios', [Funcionarios::class, 'inserir']);
    Route::delete('/funcionarios', [Funcionarios::class, 'deletar']);
    Route::put('/funcionarios', [Funcionarios::class, 'editar']);
    Route::patch('/funcionarios', [Funcionarios::class, 'mudar_senha']);

    Route::patch('/mudar_senha', [MyLogin::class, 'mudarSenha']);


    Route::get('/processos', [Processos::class, 'index']);
    Route::post('/processos', [Processos::class, 'inserir']);
    Route::delete('/processos', [Processos::class, 'deletar']);
    Route::put('/processos', [Processos::class, 'editar']);

    Route::post('/seguir_fluxo', [Processos::class, 'seguir_fluxo']);
    Route::post('/desvincular_processo', [Processos::class, 'desvincular_processo']);

    Route::get('/status', [Status::class, 'index']);
    Route::post('/status', [Status::class, 'inserir']);
    Route::delete('/status', [Status::class, 'deletar']);
    Route::put('/status', [Status::class, 'editar']);
    
   

    Route::get('/passos_processo/{processo_id}', [Passos::class, 'index']);
    Route::put('/passos_processo', [Passos::class, 'vincular_status']);
    Route::patch('/passos_processo', [Passos::class, 'gerenciar_quem_decide']);
    Route::get('/desvincular/{id}', [Passos::class, 'desvincular_status']);

    Route::get('/desenho_fluxos', [Fluxos::class, 'index']);

    Route::get('/anexos_obs/{documento_id}', [Anexos_Obs::class, 'index']);


    Route::get('/config/{documento_id}', [Config::class, 'index']);
    Route::post('/config', [Config::class, 'inserir_doc']);
    Route::put('/config', [Config::class, 'editar_descricao']);
    Route::patch('/config', [Config::class, 'trocar_principal']);
    
    
    Route::post('/obs', [Anexos_Obs::class, 'inserir_obs']);
    Route::delete('/obs', [Anexos_Obs::class, 'deletar_obs']);
    Route::put('/obs', [Anexos_Obs::class, 'editar_obs']);
    
});


Route::get('/login', [MyLogin::class, 'index'] )->name('login');
Route::post('/login', [MyLogin::class, 'login'] );
Route::get('/logout', [MyLogin::class, 'logout']);
Route::patch('/mudar-senha', [MyLogin::class, 'mudarSenha']);
