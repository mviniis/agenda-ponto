<?php

namespace App\Models\Packages\App\Tarefa\Actions;

use \App\Models\DTOs\PrioridadeTarefaDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;

/**
 * class PrioridadeTarefaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'prioridade_tarefa'
 * 
 * @author Matheus Vinicius
 */
class PrioridadeTarefaAction extends DBExecute {
  protected ?string $table = 'prioridade_tarefa';
  protected ?string $modelData = PrioridadeTarefaDTO::class;
}