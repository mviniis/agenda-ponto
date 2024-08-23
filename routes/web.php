<?php

use \Illuminate\Support\Facades\Route;
use \App\Http\Middleware\App\{AppRequireLogin};

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

// REQUISIÇÕES QUE RETORNARÃO UMA PÁGINA
Route::middleware([AppRequireLogin::class])->group(function() {
  Route::get('/', [
    \App\Http\Controllers\App\Inicio\Get::class, 'consultar'
  ])->name('web.ver.login');

  Route::get('/recuperar-senha/parte2', [
    \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp2'
  ])->name('web.ver.recuperacaop2');
  
  Route::get('/recuperar-senha/parte3', [
    \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp3'
  ])->name('web.ver.recuperacaop3');

  Route::get('/cadastro', [
    \App\Http\Controllers\App\Cadastro\Get::class, 'consultar'
  ])->name('web.ver.cadastro');

  Route::get('/recuperar-senha', [
    \App\Http\Controllers\App\Recuperacao\Get::class, 'consultar'
  ])->name('web.ver.recuperacao');
  
  Route::get('/recuperar-senha/parte2', [
    \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp2'
  ])->name('web.ver.recuperacaop2');

  Route::get('/recuperar-senha/parte3', [
    \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp3'
  ])->name('web.ver.recuperacaop3');

  Route::get('/listagem-tarefas', [
    \App\Http\Controllers\App\Listagem\Get::class, 'consultar'
  ])->name('web.ver.listagem');
  
  Route::get('/cadastrar-tarefa', [
    \App\Http\Controllers\App\Tarefa\Get::class, 'consultar'
  ])->name('web.ver.tarefa');
  
  Route::get('/editar-tarefa/{id}', [
    \App\Http\Controllers\App\Tarefa\Get::class, 'consultar'
  ])->name('web.ver.tarefa.detalhe');
  
  Route::get('/editar-perfil', [
    \App\Http\Controllers\App\Usuario\Get::class, 'consultar'
  ])->name('web.ver.perfil');
});

// REQUISIÇÕES HTTP QUE REALIZARÃO UMA AÇÃO E NÃO VÃO RETORNAR HTML
Route::middleware(['web'])->group(function() {
  Route::post('/', [
    \App\Http\Controllers\App\Inicio\Post::class, 'efetuarLogin'
  ])->name('request.logar');

  Route::post('/logout', [
    \App\Http\Controllers\App\Inicio\Post::class, 'efetuarLogout'
  ])->name('request.deslogar');
  
  Route::post('/cadastro', [
    \App\Http\Controllers\App\Cadastro\Post::class, 'cadastrarUsuario'
  ])->name('request.cadastrar');
  
  Route::post('/recuperar-senha', [
    \App\Http\Controllers\App\Recuperacao\Post::class, 'recuperarSenha'
  ])->name('request.recuperacao');
  
  Route::post('/recuperar-senha/parte2', [
    \App\Http\Controllers\App\Recuperacao\Post::class, 'validarSegundaParte'
  ])->name('request.recuperacao.parte2');
  
  Route::post('/cadastrar-tarefa', [
    \App\Http\Controllers\App\Tarefa\Post::class, 'cadastrarTarefa'
  ])->name('request.tarefa');
  
  Route::post('/editar-tarefa', [
    \App\Http\Controllers\App\Tarefa\Post::class, 'atualizarTarefa'
  ])->name('request.tarefa.detalhe');
  
  Route::delete('/remover-tarefa', [
    \App\Http\Controllers\App\Tarefa\Delete::class, 'remover'
  ])->name('request.tarefa.detalhe.remocao');

  Route::post('/concluir-tarefa', [
    \App\Http\Controllers\App\Tarefa\Post::class, 'concluirTarefa'
  ])->name('request.tarefa.detalhe.conclusao');
  
  Route::post('/editar-perfil', [
    \App\Http\Controllers\App\Usuario\Post::class, 'atualizar'
  ])->name('request.perfil');
});
