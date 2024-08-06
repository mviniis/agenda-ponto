<?php

namespace App\Http\Controllers\App\Inicio;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use Illuminate\Http\JsonResponse;

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de início do site
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
  public function efetuarLogin(Request $request) {
    return response()->json([
      'status'   => true,
      'mensagem' => 'Login efetuado'
    ]);
  }
}