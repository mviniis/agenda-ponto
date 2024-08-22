<?php

namespace App\Http\Controllers\App\Listagem;

use \App\Http\Controllers\Framework\Base;
use App\Models\Packages\App\Tarefa\Actions\TarefaAction;
use App\Models\Packages\App\Tarefa\Validates\Tarefa;

use App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};
use \App\Models\Packages\Sistema\Paginacao\Paginacao;

use function Psy\debug;

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de listagem de tarefas
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {

  private $listaItens;

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
      'geral', 'botstrap', 'listagem-tarefas', 'tarefas'
    ]);

    // DEFINIÇÃO DOS OBJETOS
    $this->handlerCSS = $obHandlerCSS;
    $this->handlerJS  = $obHandlerJS;

    return $this;
  }

  public function gerarPaginacao(): self {
    // GERA A PAGINAÇÃO
    $totalItens        = (new TarefaAction)->buscaTotalTarefasPorUsuario((new UsuarioSessao)->getIdUsuarioLogado());
    $itensPorPagina    = $_ENV['APP_ITENS_POR_PAGINA'];
    $itensVisualizados = 5;
    $obPaginacao       = new Paginacao($totalItens, $itensPorPagina, $_GET['pagina'] ?? 0, '/listagem-tarefas');
    // SALVA A PAGINAÇÃO
    $this->paginacao = [
      'total'          => (new TarefaAction)->buscaTotalTarefasPorUsuario((new UsuarioSessao)->getIdUsuarioLogado()),
      'itensPorPagina' => $itensPorPagina,
      'itensVisiveis'  => $itensVisualizados,
      'paginacao'      => $obPaginacao->generate()
    ];

    return $this;
  }


  public function buscarTarefasUsuario(){

    $obTarefas = new Tarefa();
    $tarefas = $obTarefas->getTarefas($_GET['pagina'] ?? 0);

    
    $this->addConteudo('tarefasUsuario', $tarefas);

  }

  /**
   * Método responsável por realizar a chamada do conteúdo da página
   * @return string
   */
  public function consultar() {
    $this->configure()->gerarPaginacao();

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    $this->buscarTarefasUsuario();

    return $this->getConteudo('listagem-tarefas');
  }
}
