<?php

namespace App\Models\Packages\App\TarefaUsuario\Actions;

use App\Models\DTOs\TarefaDTO;
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
class TarefaUsuarioAction extends DBExecute {
  protected ?string $table = 'tarefa_usuario';
  protected ?string $modelData = TarefaUsuarioDTO::class;
  
  /**
   * Método responsável por buscar o proprietário de uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @param int $idPerfilAdmin - Identificador de um perfil admin
   * @return DBEntity
   */
  public function getProprietarioTarefa(int $idTarefa, int $idPerfilAdmin){

    $condicoes = new SQLWhereGroup('AND', [
      new SQLWhere('tarefa_usuario.id_tarefa', '=', $idTarefa),
      new SQLWhere('tarefa_usuario.id_perfil_tarefa', '=', $idPerfilAdmin),
    ]);

    $joins   = [];
    $joins[] = new SQLJoin('perfil_tarefa', condicoes: new SQLWhere('tarefa_usuario.id_perfil_tarefa', '=', 'perfil_tarefa.id', true));
    $joins[] = new SQLJoin('usuario', condicoes: new SQLWhere('tarefa_usuario.id_usuario', '=', 'usuario.id', true));
    $joins[] = new SQLJoin('pessoa', condicoes: new SQLWhere('usuario.id_pessoa', '=', 'pessoa.id', true));
    $joins[] = new SQLJoin('pessoa_fisica', tipo: 'LEFT' , condicoes: new SQLWhere('pessoa.id', '=', 'pessoa_fisica.id_pessoa', true));
    $joins[] = new SQLJoin('pessoa_juridica', tipo: 'LEFT' , condicoes: new SQLWhere('pessoa.id', '=', 'pessoa_juridica.id_pessoa', true));


    $campos = [
      new SQLFields('nome', 'pessoa_fisica'),
      new SQLFields('sobrenome', 'pessoa_fisica'),
      new SQLFields('nome_fantasia', 'pessoa_juridica'),
      new SQLFields('email', 'pessoa')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchObject();
  }

  /**
   * Método responsável por buscar o nível de permissão que o usuário tem para uma tarefa
   * @param int $idTarefa - ID da tarefa
   * @param int $idUsuario - ID do usuário
   * @return DBEntity
   */
  public function getPermissaoTarefa(int $idTarefa, int $idUsuario){

    $condicoes = new SQLWhereGroup('AND', [
      new SQLWhere('tarefa_usuario.id_tarefa', '=', $idTarefa),
      new SQLWhere('tarefa_usuario.id_usuario', '=', $idUsuario),
    ]);

    $joins   = [];
    $joins[] = new SQLJoin('perfil_tarefa', condicoes: new SQLWhere('tarefa_usuario.id_perfil_tarefa', '=', 'perfil_tarefa.id', true));

    $campos = [
      new SQLFields('nome', 'perfil_tarefa'),
      new SQLFields('visualizar', 'perfil_tarefa'),
      new SQLFields('editar', 'perfil_tarefa'),
      new SQLFields('remover', 'perfil_tarefa')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchObject();
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

  /**
   * Método responsável por cadastrar o vínculo de um usuário com uma tarefa
   * @param int          $idUsuario   ID do usuário
   * @return int
   */
  public function cadastrarMapeamentoTarefa($idUsuario, $idTarefa){
    $sets= new SQLValues([
      new SQLValuesGroup([$idTarefa, $idUsuario, 1])
    ]);

    $fields = [
      new SQLFields('id_tarefa'),
      new SQLFields('id_usuario'),
      new SQLFields('id_perfil_tarefa')
    ];

    return $this->insert($fields, $sets)->rowCount();
  }

}