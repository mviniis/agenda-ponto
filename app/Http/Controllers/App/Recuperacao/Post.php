<?php

namespace App\Http\Controllers\App\Recuperacao;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de recuperação de senha do usuário
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição da recuperação de senha
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function recuperarSenha(Request $request) {
    return response()->json([
      'status'   => true,
      'mensagem' => 'Senha recuperada com sucesso!'
    ]);
  }
}