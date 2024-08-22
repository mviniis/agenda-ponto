<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaFisicaDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLSet, SQLSetItem, SQLWhere};

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

  /**
   * Método responsável por atualizar os dados de uma pessoa física
   * @param  PessoaFisicaDTO      $obPessoa      Dados da pessoa física
   * @return bool
   */
  public function atualizarPessoa(PessoaFisicaDTO $obPessoa): bool {
    $idPessoa = $obPessoa->idPessoa;
    if(!is_numeric($idPessoa) || $idPessoa <= 0) return false;

    // CONDIÇÃOES DA ATUALIZAÇÃO
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);

    // CAMPOS PARA ATUALIZAR
    $sets   = [];
    $campos = ['cpf', 'nome', 'sobrenome'];
    foreach($campos as $campo) {
      if(is_null($obPessoa->$campo)) continue;

      $sets[] = new SQLSetItem($campo, $obPessoa->$campo);
    }

    if(empty($sets)) return false;
    return $this->update(new SQLSet($sets), $condicao)->rowCount() > 0;
  }
}