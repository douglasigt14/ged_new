<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MyLogin;
use App\Http\Middleware\MyAuth;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Setores;
use App\Http\Controllers\Fluxos;
use App\Http\Controllers\Funcionarios;
use App\Http\Controllers\Processos;

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


    Route::get('/setores', [Setores::class, 'index']);
    Route::post('/setores', [Setores::class, 'inserir']);
    Route::delete('/setores', [Setores::class, 'deletar']);
    Route::put('/setores', [Setores::class, 'editar']);

    Route::get('/funcionarios', [Funcionarios::class, 'index']);
    Route::post('/funcionarios', [Funcionarios::class, 'inserir']);
    Route::delete('/funcionarios', [Funcionarios::class, 'deletar']);
    Route::put('/funcionarios', [Funcionarios::class, 'editar']);
    Route::patch('/funcionarios', [Funcionarios::class, 'mudar_senha']);


    Route::get('/processos', [Processos::class, 'index']);
    Route::post('/processos', [Processos::class, 'inserir']);
    Route::delete('/processos', [Processos::class, 'deletar']);
    Route::put('/processos', [Processos::class, 'editar']);

    Route::get('/desenho_fluxos', [Fluxos::class, 'index']);
    
});


Route::get('/login', [MyLogin::class, 'index'] )->name('login');
Route::post('/login', [MyLogin::class, 'login'] );
Route::get('/logout', [MyLogin::class, 'logout']);
Route::patch('/mudar-senha', [MyLogin::class, 'mudarSenha']);
