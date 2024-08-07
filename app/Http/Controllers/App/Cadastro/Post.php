<?php

namespace App\Http\Controllers\App\Cadastro;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de cadastro de usuário
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de login
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function cadastrarUsuario(Request $request) {
    return response()->json([
      'status'   => true,
      'mensagem' => 'Cadastro efetuado com sucesso!'
    ]);
  }
}