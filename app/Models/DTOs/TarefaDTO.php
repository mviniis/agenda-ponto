<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class TarefaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'tarefa'
 * 
 * @author Matheus Vinicius
 */
class TarefaDTO extends DTO {
  protected $id;
  protected $nome;
  protected $descricao;
  protected $idPrioridade;
  protected $concluido;

  public function getParametrosTabela(): array {
    return ['id', 'nome', 'descricao', 'id_prioridade', 'concluido'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'nome', 'descricao', 'idPrioridade', 'concluido'];
  }

}