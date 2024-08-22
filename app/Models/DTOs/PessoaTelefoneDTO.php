<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PessoaTelefoneDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'pessoa_telefone'
 * 
 * @author Matheus Vinicius
 */
class PessoaTelefoneDTO extends DTO {
  protected $id;
  protected $idPessoa;
  protected $telefoneContato;
  protected $telefoneCelular;
  protected $telefoneResidencial;

  public function getParametrosTabela(): array {
    return ['id', 'id_pessoa', 'telefone_contato', 'telefone_celular', 'telefone_residencial'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'idPessoa', 'telefoneContato', 'telefoneCelular', 'telefoneResidencial'];
  }
}