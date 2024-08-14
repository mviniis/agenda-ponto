<?php

namespace App\Http\Controllers\App\Inicio;

use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de início do site
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {
  public function configure(): self {
    // INSTÂNCIA DOS ARQUIVOS DE ESTILO
    $obHandlerCSS = new HandlerCss;
    $obHandlerJS  = new HandlerJs;

    // DEFINE O NOME DO ARQUIVO DE HANDLER
    $obHandlerCSS->defineHandlerFileName('handler-inicio');
    $obHandlerJS->defineHandlerFileName('handler-inicio');

    // CONFIGURAÇÃO DOS ARQUIVOS
    $obHandlerCSS->setFilesAndFolders([
      'geral', 'inicio'
    ]);
    $obHandlerJS->setFilesAndFolders([
      'geral'
    ]);

    // DEFINIÇÃO DOS OBJETOS
    $this->handlerCSS = $obHandlerCSS;
    $this->handlerJS  = $obHandlerJS;

    return $this;
  }

  /**
   * Método responsável por realizar a chamada do conteúdo da página
   * @return string
   */
  public function consultar() {
    $this->configure();

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo('inicio');
  }
}
