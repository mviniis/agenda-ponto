<?php

namespace App\Http\Controllers\App\Usuario;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de atualização do perfil do usuário
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de atualização do perfil de usuário
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function atualizar(Request $request) {
    return response()->json([
      'status'   => true,
      'mensagem' => 'Perfil atualizado com sucesso!'
    ]);
  }
}