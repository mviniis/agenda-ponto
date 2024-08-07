<?php

namespace App\Http\Controllers\App\Tarefa;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;

/**
 * class Delete
 * 
 * Classe responsável por controlar as requisições POST da página de cadastro ou atualização de uma tarefa
 * 
 * @author Matheus Vinicius
 */
class Delete extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de login
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function remover(Request $request) {
    return response()->json([
      'status'   => true,
      'mensagem' => 'Tarefa removida com sucesso!'
    ]);
  }
}