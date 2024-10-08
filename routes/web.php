<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [
  \App\Http\Controllers\App\Inicio\Get::class, 'consultar'
])->name('web.ver.login');

Route::post('/', [
  \App\Http\Controllers\App\Inicio\Post::class, 'efetuarLogin'
])->name('request.logar');

Route::get('/cadastro', [
  \App\Http\Controllers\App\Cadastro\Get::class, 'consultar'
])->name('web.ver.cadastro');

Route::post('/cadastro', [
  \App\Http\Controllers\App\Cadastro\Post::class, 'cadastrarUsuario'
])->name('request.cadastrar');

Route::get('/recuperar-senha', [
  \App\Http\Controllers\App\Recuperacao\Get::class, 'consultar'
])->name('web.ver.recuperacao');

Route::get('/recuperar-senha/parte2', [
  \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp2'
])->name('web.ver.recuperacaop2');

Route::get('/recuperar-senha/parte3', [
  \App\Http\Controllers\App\Recuperacao\Get::class, 'consultarp3'
])->name('web.ver.recuperacaop3');

Route::post('/recuperar-senha', [
  \App\Http\Controllers\App\Recuperacao\Post::class, 'recuperarSenha'
])->name('request.recuperacao');

Route::get('/listagem-tarefas', [
  \App\Http\Controllers\App\Listagem\Get::class, 'consultar'
])->name('web.ver.listagem');

Route::get('/cadastrar-tarefa', [
  \App\Http\Controllers\App\Tarefa\Get::class, 'consultar'
])->name('web.ver.tarefa');

Route::post('/cadastrar-tarefa', [
  \App\Http\Controllers\App\Tarefa\Post::class, 'cadastrarAtualizarTarefa'
])->name('request.tarefa');

Route::get('/editar-tarefa/{id}', [
  \App\Http\Controllers\App\Tarefa\Get::class, 'consultar'
])->name('web.ver.tarefa.detalhe');

Route::post('/editar-tarefa', [
  \App\Http\Controllers\App\Tarefa\Post::class, 'cadastrarAtualizarTarefa'
])->name('request.tarefa.detalhe');

Route::delete('/remover-tarefa', [
  \App\Http\Controllers\App\Tarefa\Delete::class, 'remover'
])->name('request.tarefa.detalhe.remocao');

Route::get('/editar-perfil', [
  \App\Http\Controllers\App\Usuario\Get::class, 'consultar'
])->name('web.ver.perfil');

Route::post('/editar-perfil', [
  \App\Http\Controllers\App\Usuario\Post::class, 'atualizar'
])->name('request.perfil');