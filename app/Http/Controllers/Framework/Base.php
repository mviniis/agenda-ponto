<?php

namespace App\Http\Controllers\Framework;

use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};

/**
 * class Base
 * 
 * Classe responsável por representar um controller de uma rota
 * 
 * @author Matheus Vinicius
 */
abstract class Base extends Controller implements BaseInterface {
  /**
   * Guarda o objeto de definição dos estilos da página 
   * @var HandlerCss
   */
  protected HandlerCss $handlerCSS;

  /**
   * Guarda o objeto de definição dos scripts da página 
   * @var HandlerJs
   */
  protected HandlerJs $handlerJS;
}