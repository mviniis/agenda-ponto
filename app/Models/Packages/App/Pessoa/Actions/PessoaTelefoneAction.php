<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaTelefoneDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLFields, SQLSet, SQLSetItem, SQLWhere};

/**
 * class PessoaFisicaAction
 * 
 * Classe responsável por realizar a manipulação dos dados da tabela 'pessoa_fisica'
 * 
 * @author Matheus Vinicius
 */
class PessoaTelefoneAction extends DBExecute {
  protected ?string $table     = 'pessoa_telefone';
  protected ?string $modelData = PessoaTelefoneDTO::class;

  /**
   * Método responsável por buscar o telefone de contato de um usuário
   * @param  int      $idPessoa      ID da pessoa que referencia o usuário
   * @return DBEntity
   */
  public function getTelefoneContatoPorIdPessoa(int $idPessoa): DBEntity {
    $campos   = [new SQLFields('telefone_contato')];
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);
    return $this->select($condicao, fields: $campos)->fetchObject();
  }

  /**
   * Método responsável por realziar a atualização dos dados de telefone de uma pessoa
   * @param  PessoaTelefoneDTO      $obPessoaTelefoneDTO      Dados dos telefones
   * @return bool
   */
  public function atualizarTelefones(PessoaTelefoneDTO $obPessoaTelefoneDTO): bool {
    $idPessoa = $obPessoaTelefoneDTO->idPessoa;
    if(!is_numeric($idPessoa) || $idPessoa <= 0) return false;

    // CONDIÇÃO
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);

    // SALVA OS DADOS DOS TELEFONES
    $sets   = [];
    $campos = [
      'telefone_contato'     => 'telefoneContato', 
      'telefone_celular'     => 'telefoneCelular', 
      'telefone_residencial' => 'telefoneResidencial'
    ];
    foreach($campos as $campoTabela => $campoDTO) {
      if(is_null($obPessoaTelefoneDTO->$campoDTO)) continue;

      $sets[] = new SQLSetItem($campoTabela, $obPessoaTelefoneDTO->$campoDTO);
    }

    if(empty($sets)) return false;
    return $this->update(new SQLSet($sets), $condicao)->rowCount() > 0;
  }
}