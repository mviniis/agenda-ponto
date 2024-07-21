<?php

namespace App\Models;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PerfilTarefaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'perfil_tarefa'
 * 
 * @author Matheus Vinicius
 */
class PerfilTarefaDTO extends DTO {
  protected $id;
  protected $nome;
  protected $visualizar;
  protected $editar;
  protected $remover;

  public function getParametrosTabela(): array {
    return ['id', 'nome', 'visualizar', 'editar', 'remover'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'nome', 'visualizar', 'editar', 'remover'];
  }
}