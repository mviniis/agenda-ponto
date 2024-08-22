<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLFields, SQLWhere, SQLJoin, SQLSet, SQLSetItem};

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

  /**
   * Método responsável por verificar se o e-mail já foi cadastrado
   * @param  string       $email       E-mail que será validado
   * @return bool
   */
  public function verificarDuplicidadeEmail(string $email): bool {
    $condicao = new SQLWhere('email', '=', $email);
    $campos   = [new SQLFields('id', aliasCampo: 'total', function: 'COUNT')];
    return $this->select($condicao, fields: $campos)->fetchColumn() > 0;
  }

  /**
   * Método responsável por realizar a atualização do e-mail de uma pessoa
   * @param  PessoaDTO      $obPessoa      Objeto da pessoa que será atualizada
   * @return bool
   */
  public function atualizarEmailPessoa(PessoaDTO $obPessoa): bool {
    if(!is_numeric($obPessoa->id) || $obPessoa->id <= 0) return false;

    // CONDIÇÃO PARA A ATUALIZAÇÃO
    $condicao = new SQLWhere('id', '=', $obPessoa->id);
    
    // DEFINE O CAMPO QUE SERÁ ATUALIZADO
    $set = new SQLSet([
      new SQLSetItem('email', $obPessoa->email)
    ]);

    return $this->update($set, $condicao)->rowCount() > 0;
  }
}