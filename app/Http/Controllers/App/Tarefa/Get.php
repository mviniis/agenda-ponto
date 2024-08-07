<?php

namespace App\Http\Controllers\App\Tarefa;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de cadastro de uma nova tarefa ou edição de uma tarefa existente
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {
  /**
   * Guarda o nome do arquivo de layout que será acessado
   * @var string
   */
  private string $nameFileLayout;

  /**
   * Método responsável por realizar o redirecionamento de links
   * @param  string       $uri       URI de redirecionamento
   * @return void
   */
  private function redirecionar(string $uri = 'listagem-tarefas'): void {
    header("Location: {$_ENV['APP_URL']}/{$uri}");
    exit;
  }

  /**
   * Método responsável por realizar a validação de qual conteúdo irá ser exibido
   * @param  Request      $request       Dados da requisição
   * @param  string       $idTarefa      ID da tarefa que deve ser acessada
   * @return self
   */
  private function validarAcesso(Request $request, $idTarefa): self {
    switch($request->route()->getName()) {
      case 'web.ver.tarefa':
        $this->nameFileLayout = 'criar-tarefa';
        if(!is_null($idTarefa) || is_numeric($idTarefa)) $this->redirecionar("editar-tarefa/{$idTarefa}");

        $this->addConteudo('uriFormulario', "cadastrar-tarefa");
      break;

      case 'web.ver.tarefa.detalhe':
        $this->nameFileLayout = 'editar-tarefa';
        if(!strlen(trim($idTarefa))) $this->redirecionar();

        // VALIDA SE O ID DA TAREFA PASSADO POR PARÂMETRO É VALOR INTEIRO
        if(!is_numeric((int) $idTarefa) || $idTarefa <= 0 || !filter_var($idTarefa, FILTER_VALIDATE_INT)) {
          $this->redirecionar('cadastrar-tarefa');
        }

        $this->addConteudo('uriFormulario', "editar-tarefa/{$idTarefa}");
      break;

      default:
        $this->redirecionar();
      break;
    }

    return $this;
  }

  public function configure(): self {
    // INSTÂNCIA DOS ARQUIVOS DE ESTILO
    $obHandlerCSS = new HandlerCss;
    $obHandlerJS  = new HandlerJs;

    // DEFINE O NOME DO ARQUIVO DE HANDLER
    $obHandlerCSS->defineHandlerFileName('handler-criar-tarefa');
    $obHandlerJS->defineHandlerFileName('handler-criar-tarefa');

    // CONFIGURAÇÃO DOS ARQUIVOS
    $obHandlerCSS->setFilesAndFolders([
      'geral', 'botstrap'
    ]);
    $obHandlerJS->setFilesAndFolders([
      'geral', 'botstrap'
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
  public function consultar(Request $request, $id = null) {
    $this->validarAcesso($request, $id)->configure();

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    return $this->getConteudo($this->nameFileLayout);
  }
}
