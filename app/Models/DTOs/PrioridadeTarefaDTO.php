<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PrioridadeTarefaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'prioridade_tarefa'
 * 
 * @author Matheus Vinicius
 */
class PrioridadeTarefaDTO extends DTO {
  protected $id;
  protected $label;

  public function getParametrosTabela(): array {
    return ['id', 'label'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'label'];
  }
}