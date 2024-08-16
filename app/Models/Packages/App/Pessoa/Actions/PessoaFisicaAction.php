<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaFisicaDTO;
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLWhere};
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};

/**
 * class PessoaFisicaAction
 * 
 * Classe responsável por realizar a manipulação dos dados da tabela 'pessoa_fisica'
 * 
 * @author Matheus Vinicius
 */
class PessoaFisicaAction extends DBExecute {
  protected ?string $table     = 'pessoa_fisica';
  protected ?string $modelData = PessoaFisicaDTO::class;

  /**
   * Método responsável por retornar os dados de uma pessoa física
   * @param  int      $idPessoa      ID da pessoa física
   * @return DBEntity
   */
  public function getPessoaFisicaPorIdPessoa(int $idPessoa): DBEntity {
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);
    return $this->select($condicao)->fetchObject();
  }
}