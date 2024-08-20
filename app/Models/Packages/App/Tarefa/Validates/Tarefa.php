<?php

namespace App\Models\Packages\App\Tarefa\Validates;

use App\Models\DTOs\TarefaDTO;
use App\Models\DTOs\UsuarioDTO;
use App\Models\Packages\App\Tarefa\Actions\TarefaAction;
use App\Models\Packages\App\TarefaUsuario\Actions\TarefaUsuarioAction;
use App\Models\Packages\App\Usuario\Actions\UsuarioAction;
use App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \Exception;
use \App\Models\Packages\Sistema\Senha\Gerenciador;

use function Psy\debug;

/**
 * class UsuarioLogin
 * 
 * Classe responsável por realizar a validação do login de um usuário
 * 
 * @author Matheus Vinicius
 */
class Tarefa {
  /**
   * Guarda os dados das tarefas
   * @var array
   */
  private $obTarefas;

  /**
   * Guarda os dados das tarefas
   * @var TarefaAction
   */
  private $obTarefaAction;

  public function __construct() {
    $this->obTarefaAction = new TarefaAction();
  }
  

  /**
   * Método responsável por retornar os dados de tarefas vinculadas ao usuário
   * @return array
   */
  public function getTarefas($pagina): array {

    $this->buscarTarefasUsuario($pagina)->buscaProprietarioTarefa();

    if(!is_array($this->obTarefas)) {
      throw new Exception('Não existe nenhuma tarefa válida.', 406);
    }

    return $this->obTarefas;
  }

  /**
   * Método responsável por retornar o conteúdo de uma tarefa específica
   * @param  int $idTarefa
   * @return array
   */
  public function getConteudoTarefa($idTarefa): array {

    $obEntity = $this->obTarefaAction->getTarefaPorId($idTarefa);

    $this->obTarefas = $this->toArray($obEntity->getData(), 'unitaria');

    return $this->obTarefas;
  }


  /**
   * Método responsável por verificar se o usuário existe na base de dados
   * @return self
   */
  private function buscarTarefasUsuario($pagina): self {

    $usuario = new UsuarioSessao;

    $idUsuario = $usuario->getIdUsuarioLogado();
    $obEntity = $this->obTarefaAction->getTarefasPorUsuario($idUsuario, $pagina);

    // VERIFICA SE A CONSULTA FOI BEM SUCEDIDA
    if(!$obEntity->getSuccess()) {
      throw new Exception(
        'Não foi encontrada nenhuma tarefa para esse usuário.', 
        404
      );
    }

    // SALVA AS TAREFAS
    $this->obTarefas = $this->toArray($obEntity->getAllData(),'multipla');

    return $this;
  }

  public function buscaProprietarioTarefa(){
    $obTarefaUsuario = new TarefaUsuarioAction();
    
    foreach($this->obTarefas as $tarefa){
      $obRetorno = $obTarefaUsuario->getProprietarioTarefa($tarefa['id'], 1);
      $obRetorno = $obRetorno->getData();

      $nome = empty($obRetorno->nome_fantasia) ? $obRetorno->nome . ' ' .  $obRetorno->sobrenome : $obRetorno->nome_fantasia;
      $email = $obRetorno->email;


      $tarefa['responsavel'] = $nome . ' (' . $email . ')';

      $newArrTarefas[] = $tarefa;
      
    }

    $this->obTarefas = $newArrTarefas;

    return $this;

  }

  public function cadastrarTarefa($dadosCadastro){
    $this->obTarefaAction->cadastrarTarefa($dadosCadastro);
  }

  public function atualizaTarefa($dadosAtualizacao){
    $this->obTarefaAction->atualizaTarefa($dadosAtualizacao);
  }

  
  public function toArray($obTarefas, $tipo): array {

    $arrTarefas = [];

    if($tipo == 'multipla'){
      foreach($obTarefas as $obTarefa) {
        $arrTarefas[] = [
            'id' => $obTarefa->id,
            'nome' => $obTarefa->nome,
            'descricao' => $obTarefa->descricao,
            'idPrioridade' => $obTarefa->idPrioridade,
            'concluido' => $obTarefa->concluido,
            'prioridade' => $obTarefa->prioridade
        ];
      }
    }
    else {
      $arrTarefas = [
        'id' => $obTarefas->id,
        'nome' => $obTarefas->nome,
        'descricao' => $obTarefas->descricao,
        'idPrioridade' => $obTarefas->idPrioridade,
        'concluido' => $obTarefas->concluido,
        'prioridade' => $obTarefas->prioridade
      ];
    }

    
    return $arrTarefas;
  }

}