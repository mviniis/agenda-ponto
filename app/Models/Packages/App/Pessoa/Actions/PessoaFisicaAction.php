<?php

namespace App\Models\Packages\App\Pessoa\Actions;

use \App\Models\DTOs\PessoaFisicaDTO;
use \Mviniis\ConnectionDatabase\DB\{DBEntity, DBExecute};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLFields, SQLSet, SQLSetItem, SQLValues, SQLValuesGroup, SQLWhere};

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

  /**
   * Método responsável por verificar se o CPF informado já existe no banco
   * @param  string       $cpf       CPF do usuário
   * @return bool
   */
  public function validarDuplicidadeCpf(string $cpf): bool {
    $condicao = new SQLWhere('cpf', '=', $cpf);
    $campo    = [
      new SQLFields('id', function: 'COUNT')
    ];

    $quantidade = (int) $this->select($condicao, fields: $campo)->fetchColumn();
    return $quantidade > 0;
  }

  /**
   * Método responsável por cadastrar os dados pessoais de uma pessoa física
   * @param  PessoaFisicaDTO       $obPessoaFisicaDTO       Dados da pessoa física do usuário a ser adicionado
   * @return bool
   */
  public function salvar(PessoaFisicaDTO $obPessoaFisicaDTO): bool {
    $fields = [
      new SQLFields('id_pessoa'), new SQLFields('cpf'),
      new SQLFields('nome'), new SQLFields('sobrenome')
    ];

    $values = new SQLValues([
      new SQLValuesGroup([
        $obPessoaFisicaDTO->idPessoa, 
        $obPessoaFisicaDTO->cpf,
        $obPessoaFisicaDTO->nome,
        $obPessoaFisicaDTO->sobrenome
      ])
    ]);

    $idUsuario = $this->insert($fields, $values)->getLastInsertId();
    return is_numeric($idUsuario);
  }
}