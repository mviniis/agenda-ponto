<?php

namespace App\Models\Packages\App\Tarefa\Actions;

use App\Models\DTOs\TarefaDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLFields;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLJoin;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLOrder;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLSet;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLSetItem;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLValues;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLValuesGroup;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLWhere;

/**
 * class TarefaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'tarefa'
 * 
 * @author Matheus Vinicius
 */
class TarefaAction extends DBExecute {
  protected ?string $table = 'tarefa';
  protected ?string $modelData = TarefaDTO::class;

  /**
   * Método responsável por buscar as tarefas de um usuário
   * @param  string       $email       E-mail do usuário que está efetuando login
   * @param  string       $senha       Senha do usuário
   * @return DBEntity
   */
  public function getTarefasPorUsuario (int $idUsuario, int $pagina) {
    $condicoes = new SQLWhere('tarefa_usuario.id_usuario', '=', $idUsuario);

    $joins   = [];
    $joins[] = new SQLJoin('tarefa_usuario',condicoes: new SQLWhere('tarefa.id', '=', 'tarefa_usuario.id_tarefa', true));
    $joins[] = new SQLJoin('prioridade_tabela', condicoes: new SQLWhere('tarefa.id_prioridade', '=', 'prioridade_tabela.id', true));

    $campos = [
      new SQLFields('id', 'tarefa'),
      new SQLFields('nome', 'tarefa'),
      new SQLFields('descricao', 'tarefa'),
      new SQLFields('concluido', 'tarefa'),
      new SQLFields('label', 'prioridade_tabela', 'prioridade')
    ];

    $offset = $_ENV['APP_ITENS_POR_PAGINA'] * $pagina;

    $order = new SQLOrder('concluido',direction:'DESC');

    return $this->select($condicoes, $joins, $campos, $order, $_ENV['APP_ITENS_POR_PAGINA'],$offset)->fetchAllObjects();
  }

  /**
   * Método responsável por buscar os dados uma tarefa específica
   * @param int $idTarefa - ID da tarefa
   * @return DBEntity
   */
  public function getTarefaPorId (int $idTarefa) {
    
    $condicoes = new SQLWhere('tarefa.id', '=', $idTarefa);

    $joins   = [];
    $joins[] = new SQLJoin('prioridade_tabela', condicoes: new SQLWhere('tarefa.id_prioridade', '=', 'prioridade_tabela.id', true));

    $campos = [
      new SQLFields('id', 'tarefa'),
      new SQLFields('nome', 'tarefa'),
      new SQLFields('descricao', 'tarefa'),
      new SQLFields('concluido', 'tarefa'),
      new SQLFields('label', 'prioridade_tabela', 'prioridade')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchObject();
  }

  /**
   * Método responsável por buscar as tarefas de um usuário
   * @param int          $idUsuario   ID do usuário
   * @return DBEntity
   */
  public function buscaTotalTarefasPorUsuario (int $idUsuario) {
    $condicoes = new SQLWhere('tarefa_usuario.id_usuario', '=', $idUsuario);

    $joins   = [];
    $joins[] = new SQLJoin('tarefa_usuario', condicoes: new SQLWhere('tarefa.id', '=', 'tarefa_usuario.id_tarefa', true));
    $joins[] = new SQLJoin('prioridade_tabela', condicoes: new SQLWhere('tarefa.id_prioridade', '=', 'prioridade_tabela.id', true));

    // CAMPOS QUE SERÃO RETORNADOS
    $campos = [
      new SQLFields('id', 'tarefa','total','COUNT')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchColumn();
  }

  /**
   * Método responsável por atualizar os dados de uma tarefa
   * @param array $dadosAtualizacao - Dados da tarefa
   * @return int
   */
  public function atualizaTarefa (array $dadosAtualizacao) {
    
    $condicoes = new SQLWhere('id', '=', $dadosAtualizacao['idTarefa']);

    $sets= new SQLSet([
      new SQLSetItem('nome', $dadosAtualizacao['nome']),
      new SQLSetItem('descricao', $dadosAtualizacao['descricao']),
      new SQLSetItem('id_prioridade', $dadosAtualizacao['prioridade']),
    ]);

    return $this->update($sets,$condicoes)->rowCount();
  }

  /**
   * Método responsável por cadastrar uma tarefa
   * @param array $dadosTarefa - Dados da tarefa
   * @return int
   */
  public function cadastrarTarefa (array $dadosTarefa) {

    $sets= new SQLValues([
      new SQLValuesGroup([$dadosTarefa['nome'],$dadosTarefa['descricao'],$dadosTarefa['prioridade'],'n'])
    ]);

    $fields = [
      new SQLFields('nome'),
      new SQLFields('descricao'),
      new SQLFields('id_prioridade'),
      new SQLFields('concluido')
    ];

    return $this->insert($fields,$sets)->getLastInsertId();
  }

  /**
   * Método responsável por excluir uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @return int
   */
  public function excluirTarefa(int $idTarefa) {
    
    $condicoes = new SQLWhere('id', '=', $idTarefa);

    return $this->delete($condicoes)->rowCount();
  }


  /**
   * Método responsável por concluir uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @return int
   */
  public function concluirTarefa(int $idTarefa) {
    
    $condicoes = new SQLWhere('id', '=', $idTarefa);

    $sets= new SQLSet([
      new SQLSetItem('concluido', 's')
    ]);

    return $this->update($sets, $condicoes)->rowCount();
  }
  
  

}