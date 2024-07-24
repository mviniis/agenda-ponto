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
  protected ?HandlerCss $handlerCSS;

  /**
   * Guarda o objeto de definição dos scripts da página 
   * @var HandlerJs
   */
  protected ?HandlerJs $handlerJS;

  /**
   * Guarda os dados que serão utilizados no layout
   * @var array
   */
  private array $dadosLayout = [];

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->dadosLayout = [
      'URL_APP'    => $_ENV['APP_URL'],
      'URL_IMG'    => "{$_ENV['APP_URL']}/resources/img",
      'TITLE_SITE' => $_ENV['APP_TITLE_SITE'],
    ];
  }
  
  /**
   * Método responsável por salvar os dados de um item do layout
   * @param  string       $indice       Índice da array
   * @param  mixed        $valor        Valor que será adicionado
   * @return self
   */
  protected function addConteudo(string $indice, mixed $valor): self {
    if(!is_array($valor) || !is_object($valor)) $this->dadosLayout[$indice] = $valor;

    if(($valor instanceof \Illuminate\Contracts\View\View) || ($valor instanceof \Illuminate\Contracts\View\Factory)) {
      $this->dadosLayout[$indice] = $valor->render();
    }
    
    return $this;
  }

  public function atualizarHandlers(bool $forcarAtualizacao = false): void {
    if($this->handlerCSS instanceof HandlerCss) {
      $this->addConteudo('linkCss', $this->handlerCSS->getArquivoHandler($forcarAtualizacao));
    }

    if($this->handlerJS instanceof HandlerJs) {
      $this->addConteudo('srcScript', $this->handlerJS->getArquivoHandler($forcarAtualizacao));
    } 
  }

  public function getConteudo(string $pagina): mixed {
    if(isset($_ENV['APP_DEBUG_RESPONSE']) && $_ENV['APP_DEBUG_RESPONSE'] == 'true') {
      echo "<pre>"; print_r($this->dadosLayout); echo "</pre>";
    }

    return view('estrutura.estrutura', [
      'head'     => view('estrutura.head', $this->dadosLayout)->render(),
      'header'   => view('estrutura.header', $this->dadosLayout)->render(),
      'conteudo' => view('conteudo.' . $pagina, $this->dadosLayout)->render(),
      'footer'   => view('estrutura.footer', $this->dadosLayout)->render()
    ]);
  }
}