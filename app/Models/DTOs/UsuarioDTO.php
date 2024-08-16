<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class UsuarioDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'usuario'
 * 
 * @author Matheus Vinicius
 */
class UsuarioDTO extends DTO {
  protected $id;
  protected $idPessoa;
  protected $senha;

  public function getParametrosTabela(): array {
    return ['id', 'id_pessoa', 'senha'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'idPessoa', 'senha'];
  }
}