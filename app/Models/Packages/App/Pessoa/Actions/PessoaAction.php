<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLFields, SQLWhere, SQLJoin};

/**
 * class PessoaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'pessoa'
 * 
 * @author Matheus Vinicius
 */
class PessoaAction extends DBExecute {
  protected ?string $table     = 'pessoa';
  protected ?string $modelData = PessoaDTO::class;

  /**
   * Método responsável por retornar o ID do tipo de pessoa
   * @param  int      $idPessoa      ID da pessoa consultada
   * @return DBEntity
   */
  public function getIdTipoPessoa(int $idPessoa): DBEntity {
    $condicao = new SQLWhere('pessoa.id', '=', $idPessoa);

    $campos = [
      new SQLFields('id', 'pessoa_fisica', 'idPessoaFisica'),
      new SQLFields('id', 'pessoa_juridica', 'idPessoaJuridica'),
    ];

    $joins = [
      new SQLJoin('pessoa_fisica', tipo: 'LEFT', condicoes: new SQLWhere(
        'pessoa_fisica.id', '=', 'pessoa.id', true
      )),
      new SQLJoin('pessoa_juridica', tipo: 'LEFT', condicoes: new SQLWhere(
        'pessoa_juridica.id', '=', 'pessoa.id', true
      ))
    ];

    return $this->select($condicao, joins: $joins, fields: $campos)->fetchObject();
  }
}