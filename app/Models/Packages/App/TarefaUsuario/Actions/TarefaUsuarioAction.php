<?php

namespace App\Models\Packages\App\TarefaUsuario\Actions;

use App\Models\DTOs\TarefaDTO;
use App\Models\DTOs\TarefaUsuarioDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLFields;
use Mviniis\ConnectionDatabase\SQL\Parts\SQLJoin;
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

  public function getProprietarioTarefa(int $idTarefa, int $idPerfilAdmin){


    // CONDIÇÕES DO WHERE
    $condicoes = new SQLWhereGroup('AND', [
      new SQLWhere('tarefa_usuario.id_tarefa', '=', $idTarefa),
      new SQLWhere('tarefa_usuario.id_perfil_tarefa', '=', $idPerfilAdmin),
    ]);

    // MONTA O JOIN COM A TABELA PESSOA
    $joins   = [];
    $joins[] = new SQLJoin('perfil_tarefa', condicoes: new SQLWhere('tarefa_usuario.id_perfil_tarefa', '=', 'perfil_tarefa.id', true));
    $joins[] = new SQLJoin('usuario', condicoes: new SQLWhere('tarefa_usuario.id_usuario', '=', 'usuario.id', true));
    $joins[] = new SQLJoin('pessoa', condicoes: new SQLWhere('usuario.id_pessoa', '=', 'pessoa.id', true));
    $joins[] = new SQLJoin('pessoa_fisica', tipo: 'LEFT' , condicoes: new SQLWhere('pessoa.id', '=', 'pessoa_fisica.id_pessoa', true));
    $joins[] = new SQLJoin('pessoa_juridica', tipo: 'LEFT' , condicoes: new SQLWhere('pessoa.id', '=', 'pessoa_juridica.id_pessoa', true));



    // CAMPOS QUE SERÃO RETORNADOS
    $campos = [
      new SQLFields('nome', 'pessoa_fisica'),
      new SQLFields('sobrenome', 'pessoa_fisica'),
      new SQLFields('nome_fantasia', 'pessoa_juridica'),
      new SQLFields('email', 'pessoa')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchObject();
  }
}