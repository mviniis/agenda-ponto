<?php

namespace App\Http\Controllers\App\Tarefa;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use App\Models\Packages\App\Tarefa\Validates\Tarefa;

/**
 * class Delete
 * 
 * Classe responsável por controlar as requisições DELETE de uma tarefa
 * 
 * @author Matheus Vinicius
 */
class Delete extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de remoção de uma tarefa
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function remover(Request $request) {

    $status   = true;
    $mensagem = 'Tarefa removida com sucesso!';

    try {
      $obTarefa = new Tarefa();

      $request = $request->all();

      $obTarefa->excluirTarefa($request['idTarefa']);

    } catch(\Exception $ex) {
      $status           = false;
      $mensagem         = $ex->getMessage();
    }

    return response()->json([
      'status'   => $status,
      'mensagem' => $mensagem
    ]);
  }
}