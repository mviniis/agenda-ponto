<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PessoaJuridicaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'pessoa_juridica'
 * 
 * @author Matheus Vinicius
 */
class PessoaJuridicaDTO extends DTO {
  protected $id;
  protected $idPessoa;
  protected $razaoSocial;
  protected $nomeFantasia;
  protected $cnpj;

  public function getParametrosTabela(): array {
    return ['id', 'id_pessoa', 'cnpj', 'razao_social', 'nome_fantasia'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'idPessoa', 'cnpj', 'razaoSocial', 'nomeFantasia'];
  }
}