<?php

namespace App\Models\Packages\App\TarefaHistorico\Actions;

use App\Models\DTOs\TarefaDTO;
use App\Models\DTOs\TarefaHistoricoDTO;
use App\Models\DTOs\TarefaUsuarioDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLFields;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLJoin;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLValues;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLValuesGroup;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLWhere;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLWhereGroup;

/**
 * class TarefaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'tarefa'
 * 
 * @author Matheus Vinicius
 */
class TarefaHistoricoAction extends DBExecute {
  protected ?string $table = 'tarefa_historico';
  protected ?string $modelData = TarefaHistoricoDTO::class;
  
  /**
   * Método responsável por buscar o proprietário de uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @param int $idPerfilAdmin - Identificador de um perfil admin
   * @return DBEntity
   */
  public function registrarAlteracao(array $dadosAntigos, array $dadosNovos, int $idTarefa, int $idUsuario){

    //REMOVE O ID DA PRIORIDADE POIS ELE NÃO É INTERESSANTE SALVAR
    unset($dadosAntigos['idPrioridade']);
    unset($dadosNovos['idPrioridade']);


    $dadosAntigosJson = json_encode($dadosAntigos);
    $dadosNovosJson   = json_encode($dadosNovos);

    $sets= new SQLValues([
      new SQLValuesGroup(['edicao',$dadosAntigosJson,$dadosNovosJson,$idTarefa,$idUsuario])
    ]);

    $fields = [
      new SQLFields('tipo_modificacao'),
      new SQLFields('valor_antes'),
      new SQLFields('valor_depois'),
      new SQLFields('id_tarefa'),
      new SQLFields('id_usuario'),
    ];
    
    return $this->insert($fields, $sets)->rowCount();
  }

  /**
   * Método responsável por buscar o proprietário de uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @param int $idPerfilAdmin - Identificador de um perfil admin
   * @return DBEntity
   */
  public function registrarCriacao(int $idTarefa, int $idUsuario){
    
    $sets= new SQLValues([
      new SQLValuesGroup(['criacao',null,null,$idTarefa,$idUsuario])
    ]);

    $fields = [
      new SQLFields('tipo_modificacao'),
      new SQLFields('valor_antes'),
      new SQLFields('valor_depois'),
      new SQLFields('id_tarefa'),
      new SQLFields('id_usuario')
    ];

    return $this->insert($fields, $sets)->rowCount();
  }

  /**
   * Método responsável por buscar o proprietário de uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @param int $idPerfilAdmin - Identificador de um perfil admin
   * @return DBEntity
   */
  public function registrarExclusao(int $idTarefa, int $idUsuario){
    
    $sets= new SQLValues([
      new SQLValuesGroup(['remocao',null,null,$idTarefa,$idUsuario])
    ]);

    $fields = [
      new SQLFields('tipo_modificacao'),
      new SQLFields('valor_antes'),
      new SQLFields('valor_depois'),
      new SQLFields('id_tarefa'),
      new SQLFields('id_usuario')
    ];

    return $this->insert($fields, $sets)->rowCount();
  }

  /**
   * Método responsável por excluir o vínculo de um usuário com uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @return int
   */
  public function excluirMapeamentoTarefa(int $idTarefa){
    $condicoes = new SQLWhere('id_tarefa', '=', $idTarefa);

    return $this->delete($condicoes)->rowCount();
  }

}