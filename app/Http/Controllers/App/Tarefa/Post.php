<?php

namespace App\Http\Controllers\App\Tarefa;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de cadastro ou atualização de uma tarefa
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  /**
   * Guarda o status da requisição
   * @var bool
   */
  private bool $status;

  /**
   * Mensagem que será retornada na requisição
   * @var string
   */
  private string $mensagem;

  /**
   * Método responsável por 
   * @param  Request      $request       Dados da requisição
   * @param  string       $idTarefa      ID da tarefa que está sendo criada ou atualizada
   * @return self
   */
  private function validarAcesso(Request $request, $idTarefa): self {
    $this->status = true;

    switch($request->route()->getName()) {
      case 'request.tarefa':
        $this->mensagem = 'Tarefa cadastrada com sucesso!';
      break;

      case 'request.tarefa.detalhe':
        $this->mensagem = 'A tarefa foi alterada com sucesso!';
      break;

      default:
        $this->status   = false;
        $this->mensagem = 'Você não tem permissão para executar essa ação';
      break;
    }

    return $this;
  }

  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de login
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function cadastrarAtualizarTarefa(Request $request, $id = null) {
    $this->validarAcesso($request, $id);

    return response()->json([
      'status'   => $this->status,
      'mensagem' => $this->mensagem
    ]);
  }
}