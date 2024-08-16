<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PessoaFisicaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'pessoa_fisica'
 * 
 * @author Matheus Vinicius
 */
class PessoaFisicaDTO extends DTO {
  protected $id;
  protected $idPessoa;
  protected $nome;
  protected $sobrenome;
  protected $cpf;

  public function getParametrosTabela(): array {
    return ['id', 'id_pessoa', 'cpf', 'nome', 'sobrenome'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'idPessoa', 'cpf', 'nome', 'sobrenome'];
  }
}