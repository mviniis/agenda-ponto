<?php

namespace App\Models\Packages\PerfilTarefa\Actions;

use \App\Models\DTOs\PerfilTarefaDTO;
use \Mviniis\ConnectionDatabase\DB\DBExecute;

/**
 * class PerfilTarefaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'perfil_tarefa'
 * 
 * @author Matheus Vinicius
 */
class PerfilTarefaAction extends DBExecute {
  protected ?string $table = 'perfil_tarefa';
  protected ?string $modelData = PerfilTarefaDTO::class;
}