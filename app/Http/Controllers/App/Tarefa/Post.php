<?php

namespace App\Http\Controllers\App\Tarefa;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use App\Models\Packages\App\Tarefa\Actions\TarefaAction;
use App\Models\Packages\App\Tarefa\Validates\Tarefa;

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
   * @param  Request      $request      Dados da requisição
   * @return self
   */
  private function validarAcesso(Request $request): self {
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
   * Método responsável por cadastrar os dados da tarefa
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function cadastrarTarefa(Request $request) {
    $this->validarAcesso($request);

    $request = $request->all();

    $obTarefa = new Tarefa();
    $obTarefa->atualizaTarefa($request);

    return response()->json([
      'status'   => $this->status,
      'mensagem' => $this->mensagem
    ]);
  }

  /**
   * Método responsável por atualizar os dados da tarefa
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function atualizarTarefa(Request $request) {
    $this->validarAcesso($request);

    $request = $request->all();

    $obTarefa = new Tarefa();
    $obTarefa->cadastrarTarefa($request);

    return response()->json([
      'status'   => $this->status,
      'mensagem' => $this->mensagem
    ]);
  }
}