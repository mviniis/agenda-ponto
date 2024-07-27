<?php

namespace App\Models\Packages\Sistema\Handler;

/**
 * class Base
 * 
 * Classe responsável por manipular os arquivos de script do handler de uma página
 * 
 * @author Matheus Vinicius
 */
class HandlerJs extends Base {
  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->definirTipoDoArquivo('js');
  }
}