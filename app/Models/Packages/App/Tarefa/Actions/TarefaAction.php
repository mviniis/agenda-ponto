<?php

namespace App\Models\Packages\App\Tarefa\Actions;

use App\Models\DTOs\TarefaDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLFields;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLJoin;
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
    // CONDIÇÕES DO WHERE
    $condicoes = new SQLWhere('tarefa_usuario.id_usuario', '=', $idUsuario);

    // MONTA O JOIN COM A TABELA PESSOA
    $joins   = [];
    $joins[] = new SQLJoin('tarefa_usuario', condicoes: new SQLWhere('tarefa.id', '=', 'tarefa_usuario.id_tarefa', true));
    $joins[] = new SQLJoin('prioridade_tabela', condicoes: new SQLWhere('tarefa.id_prioridade', '=', 'prioridade_tabela.id', true));

    // CAMPOS QUE SERÃO RETORNADOS
    $campos = [
      new SQLFields('id', 'tarefa'),
      new SQLFields('nome', 'tarefa'),
      new SQLFields('descricao', 'tarefa'),
      new SQLFields('concluido', 'tarefa'),
      new SQLFields('label', 'prioridade_tabela', 'prioridade')
    ];

    $offset = $_ENV['APP_ITENS_POR_PAGINA'] * $pagina;

    return $this->select($condicoes, $joins, $campos, null, $_ENV['APP_ITENS_POR_PAGINA'],$offset)->fetchAllObjects();
  }

  public function getTarefaPorId (int $idTarefa) {
    
    // CONDIÇÕES DO WHERE
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
    // CONDIÇÕES DO WHERE
    $condicoes = new SQLWhere('tarefa_usuario.id_usuario', '=', $idUsuario);

    // MONTA O JOIN COM A TABELA PESSOA
    $joins   = [];
    $joins[] = new SQLJoin('tarefa_usuario', condicoes: new SQLWhere('tarefa.id', '=', 'tarefa_usuario.id_tarefa', true));
    $joins[] = new SQLJoin('prioridade_tabela', condicoes: new SQLWhere('tarefa.id_prioridade', '=', 'prioridade_tabela.id', true));

    // CAMPOS QUE SERÃO RETORNADOS
    $campos = [
      new SQLFields('id', 'tarefa','total','COUNT')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchColumn();
  }

  public function atualizaTarefa (array $dadosAtualizacao) {
    
    // CONDIÇÕES DO WHERE
    $condicoes = new SQLWhere('id', '=', $dadosAtualizacao['idTarefa']);

    $sets= new SQLSet([
      new SQLSetItem('nome', $dadosAtualizacao['nome']),
      new SQLSetItem('descricao', $dadosAtualizacao['descricao']),
      new SQLSetItem('prioridade', $dadosAtualizacao['prioridade']),
    ]);

    return $this->update($sets,$condicoes);
  }

  public function cadastrarTarefa (array $dadosAtualizacao) {
    
    // CONDIÇÕES DO WHERE
    $condicoes = new SQLWhere('id', '=', $dadosAtualizacao['idTarefa']);

    $sets= new SQLValuesGroup([
      new SQLValues('nome', $dadosAtualizacao['nome']),
      new SQLValues('descricao', $dadosAtualizacao['descricao']),
      new SQLValues('prioridade', $dadosAtualizacao['prioridade']),
    ]);

    return $this->insert($sets,$condicoes);
  }

  

}