<?php

namespace App\Http\Controllers\Framework;

/**
 * interface BaseInterface
 * 
 * Interface responsável por definir os métodos necessários em um controller
 * 
 * @author Matheus Vinicius
 */
interface BaseInterface {
  /**
   * Classe responsável por realizar a configuração de um controller
   * @return self
   */
  public function configure(): self;
}