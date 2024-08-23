<?php

namespace App\Http\Controllers\App\Recuperacao;

use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};
use \App\Models\Packages\App\RecuperacaoSenha\Validates\RecuperarSenhaValidacoes;

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de recuperação de senha de usuário
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {
  public function configure(): self {
    // INSTÂNCIA DOS ARQUIVOS DE ESTILO
    $obHandlerCSS = new HandlerCss;
    $obHandlerJS  = new HandlerJs;

    // DEFINE O NOME DO ARQUIVO DE HANDLER
    $obHandlerCSS->defineHandlerFileName('handler-recuperacao');
    $obHandlerJS->defineHandlerFileName('handler-recuperacao');

    // CONFIGURAÇÃO DOS ARQUIVOS
    $obHandlerCSS->setFilesAndFolders([
      'geral', 'botstrap', 'inicio'
    ]);
    $obHandlerJS->setFilesAndFolders([
      'geral', 'botstrap', 'recuperacao-senha'
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

    // VERIFICA SE ESTOU NA PÁGINA CORRETA
    (new RecuperarSenhaValidacoes)->validarLocal('parte1');

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo('recuperacao');
  }

  /**
   * Método responsável por realizar a chamada do conteúdo da segunda etapa da recuperação de senha
   * @return void
   */
  public function consultarp2() {
    $this->configure();

    // VERIFICA SE ESTOU NA PÁGINA CORRETA
    (new RecuperarSenhaValidacoes)->validarLocal('parte2');

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo('recuperacaop2');
  }

  /**
   * Método responsável por realizar a chamada do conteúdo da última etapa da recuperação de senha
   * @return void
   */
  public function consultarp3() {
    $this->configure();

    // VERIFICA SE ESTOU NA PÁGINA CORRETA
    (new RecuperarSenhaValidacoes)->validarLocal('parte3');

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo('recuperacaop3');
  }
}
