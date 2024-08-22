<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaJuridicaDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLWhere, SQLSet, SQLSetItem};

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

  /**
   * Método responsável por atualizar os dados de uma pessoa jurídica
   * @param  PessoaJuridicaDTO      $obPessoa      Dados da pessoa jurídica
   * @return bool
   */
  public function atualizarPessoa(PessoaJuridicaDTO $obPessoa): bool {
    $idPessoa = $obPessoa->idPessoa;
    if(!is_numeric($idPessoa) || $idPessoa <= 0) return false;

    // CONDIÇÃOES DA ATUALIZAÇÃO
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);

    // CAMPOS PARA ATUALIZAR
    $sets   = [];
    $campos = ['cnpj' => 'cnpj', 'razao_social' => 'razaoSocial', 'nome_fantasia' => 'nomeFantasia'];
    foreach($campos as $campoTabela => $campoDTO) {
      if(is_null($obPessoa->$campoDTO)) continue;

      $sets[] = new SQLSetItem($campoTabela, $obPessoa->$campoDTO);
    }

    if(empty($sets)) return false;
    return $this->update(new SQLSet($sets), $condicao)->rowCount() > 0;
  }
}