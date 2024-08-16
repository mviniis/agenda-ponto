<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PessoaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'pessoa'
 * 
 * @author Matheus Vinicius
 */
class PessoaDTO extends DTO {
  protected $id;
  protected $email;

  public function getParametrosTabela(): array {
    return ['id', 'email'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'email'];
  }
}