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
class TarefaHistoricoDTO extends DTO {
  protected $id;
  protected $tipoModificacao;
  protected $valorAntes;
  protected $valorDepois;
  protected $idTarefa;
  protected $idUsuario;
  protected $dataAlteracao;

  public function getParametrosTabela(): array {
    return ['id', 'tipo_modificacao', 'valor_antes', 'valor_depois', 'id_tarefa', 'id_usuario', 'data_hora_alteracao'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'tipoModificacao', 'valorAntes', 'valorDepois', 'idTarefa', 'idUsuario', 'dataAlteracao'];
  }
}