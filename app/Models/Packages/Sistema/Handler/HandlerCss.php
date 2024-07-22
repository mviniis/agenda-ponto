<?php

namespace App\Models\Packages\Sistema\Handler;

/**
 * class HandlerCss
 * 
 * Classe responsável por manipular os arquivos de css do handler de uma página
 * 
 * @author Matheus Vinicius
 */
class HandlerCss extends Base {
  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->definirTipoDoArquivo('css');
  }
}