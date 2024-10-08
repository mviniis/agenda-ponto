<?php

namespace App\Http\Controllers\App\Listagem;

use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};
use \App\Models\Packages\Sistema\Paginacao\Paginacao;

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de listagem de tarefas
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {
  public function configure(): self {
    // INSTÂNCIA DOS ARQUIVOS DE ESTILO
    $obHandlerCSS = new HandlerCss;
    $obHandlerJS  = new HandlerJs;

    // DEFINE O NOME DO ARQUIVO DE HANDLER
    $obHandlerCSS->defineHandlerFileName('handler-listagem-tarefas');
    $obHandlerJS->defineHandlerFileName('handler-listagem-tarefas');

    // CONFIGURAÇÃO DOS ARQUIVOS
    $obHandlerCSS->setFilesAndFolders([
      'geral', 'botstrap', 'listagem-tarefas'
    ]);
    $obHandlerJS->setFilesAndFolders([
      'geral', 'botstrap'
    ]);

    // DEFINIÇÃO DOS OBJETOS
    $this->handlerCSS = $obHandlerCSS;
    $this->handlerJS  = $obHandlerJS;

    return $this;
  }

  public function gerarPaginacao(): self {
    // GERA A PAGINAÇÃO
    $totalItens        = 100;
    $itensPorPagina    = $_ENV['APP_ITENS_POR_PAGINA'];
    $itensVisualizados = 10;
    $obPaginacao       = new Paginacao($totalItens, $itensPorPagina, $_GET['pagina'] ?? 0);
    
    // SALVA A PAGINAÇÃO
    $this->paginacao = [
      'total'          => $totalItens,
      'itensPorPagina' => $itensPorPagina,
      'itensVisiveis'  => $itensVisualizados,
      'paginacao'      => $obPaginacao->generate()
    ];

    return $this;
  }

  /**
   * Método responsável por realizar a chamada do conteúdo da página
   * @return string
   */
  public function consultar() {
    $this->configure()->gerarPaginacao();

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo('listagem-tarefas');
  }
}
