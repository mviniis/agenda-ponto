<?php

namespace App\Models\DTOs;

use \Mviniis\ConnectionDatabase\DTO\DTO;

/**
 * class PerfilTarefaDTO
 * 
 * Classe responsável por ser o modelo de transição de dados da tabela 'recuperar_senha'
 * 
 * @author Matheus Vinicius
 */
class RecuperarSenhaDTO extends DTO {
  protected $id;
  protected $idPessoa;
  protected $codigo;
  protected $dataHoraExpiracao;

  public function getParametrosTabela(): array {
    return ['id', 'id_pessoa', 'codigo', 'data_hora_expiracao'];
  }

  public function getParametrosClasse(): array {
    return ['id', 'idPessoa', 'codigo', 'dataHoraExpiracao'];
  }
}