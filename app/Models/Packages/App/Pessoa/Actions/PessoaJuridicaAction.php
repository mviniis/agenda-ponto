<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaJuridicaDTO;
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLWhere};
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};

/**
 * class PessoaJuridicaAction
 * 
 * Classe responsável por realizar a manipulação dos dados da tabela 'pessoa_juridica'
 * 
 * @author Matheus Vinicius
 */
class PessoaJuridicaAction extends DBExecute {
  protected ?string $table     = 'pessoa_juridica';
  protected ?string $modelData = PessoaJuridicaDTO::class;

  /**
   * Método responsável por retornar os dados de uma pessoa jurídica
   * @param  int      $idPessoa      ID da pessoa jurídica
   * @return DBEntity
   */
  public function getPessoaJuridicaPorIdPessoa(int $idPessoa): DBEntity {
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);
    return $this->select($condicao)->fetchObject();
  }
}