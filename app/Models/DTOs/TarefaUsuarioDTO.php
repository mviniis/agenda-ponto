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
class TarefaUsuarioDTO extends DTO {
  protected $idTarefa;
  protected $idUsuario;
  protected $idPerfilTarefa;
  protected $idPrioridade;
  protected $concluido;

  public function getParametrosTabela(): array {
    return ['id_tarefa', 'id_usuario', 'id_perfil_tarefa'];
  }

  public function getParametrosClasse(): array {
    return ['idTarefa', 'idUsuario', 'idPerfilTarefa'];
  }
}