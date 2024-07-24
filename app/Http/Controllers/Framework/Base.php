<?php

namespace App\Http\Controllers\Framework;

use \stdClass;
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
  private array $dadosLayout;

  /**
   * Define a quantidade máxima de recursões que podem ocorrer ao adicionar um novo valor ao layout
   */
  private const MAXIMO_RECURSAO = 5;

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->dadosLayout = [];

    // ADICIONA AS CONSTANTES
    $this->addConteudo('URL_APP',    $_ENV['APP_URL']);
    $this->addConteudo('URL_IMG',    "{$_ENV['APP_URL']}/resources/img");
    $this->addConteudo('TITLE_SITE', $_ENV['APP_TITLE_SITE']);
  }
  
  /**
   * Método responsável por salvar os dados de um item do layout
   * @param  string       $indice       Índice da array
   * @param  mixed        $valor        Valor que será adicionado
   * @return self
   */
  protected function addConteudo(string $indice, mixed $valor): self {
    if(!is_object($valor)) $this->dadosLayout[$indice] = $valor;

    if(($valor instanceof \Illuminate\Contracts\View\View) || ($valor instanceof \Illuminate\Contracts\View\Factory)) {
      $this->dadosLayout[$indice] = $valor->render();
    }
    
    if(is_array($valor) && !empty($valor)) $this->dadosLayout[$indice] = $this->adicionarItensArray($valor);

    return $this;
  }

  /**
   * Método responsável por montar os dados de uma array de dados de layout
   * @param  array      $dados         Dados que serão validados
   * @param  int        $recursao      Nível da recursão dos dados
   * @return mixed
   */
  private function adicionarItensArray(array $dados, int $recursao = 1): mixed {
    $retorno = new stdClass;
    foreach($dados as $indice => $valor) {
      if(($recursao) > self::MAXIMO_RECURSAO) continue;
      
      $aux = null;
      if(!is_array($valor)) $aux = $valor;

      if(is_array($valor) && (($recursao + 1) <= self::MAXIMO_RECURSAO)) {
        $aux = $this->adicionarItensArray($valor, $recursao + 1);
      }

      if(!is_null($aux)) $retorno->$indice = $aux;
    }

    return $retorno;
  }

  /**
   * Método responsável por montar o layout dos itens do debug
   * @param  mixed          $dadosLayout       Dados do layout
   * @param  int            $recursao          Define o nível da recursão dos dados
   * @param  string         $hashParent        Hash do item pai
   * @return string
   */
  private function montarLayoutDebug($dadosLayout, int $recursao = 0, string $hashParent = 'conteudoBoxDebugAcordion'): string {
    $dados    = '';
    $contador = 0;
    foreach($dadosLayout as $chave => $valor) {
      $hashItem = "indice-{$recursao}-{$contador}";
      if($valor instanceof stdClass) $valor = $this->montarLayoutDebug($valor, ($recursao + 1), $hashItem);

      $dados .= view('estrutura.debug.box-item', [
        'nomeCabecalho'  => $chave,
        'valorCabecalho' => $valor,
        'indiceItem'     => $hashItem,
        'hashParent'     => $hashParent
      ])->render();

      $contador++;
    }

    return $dados;
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
    $layoutDebug = '';
    if(isset($_ENV['APP_DEBUG_RESPONSE']) && $_ENV['APP_DEBUG_RESPONSE'] == 'true') {
      $layoutDebug = view('estrutura.debug.box', ['itens' => $this->montarLayoutDebug($this->dadosLayout)]);
    }

    return view('estrutura.estrutura', [
      'head'     => view('estrutura.head', $this->dadosLayout)->render(),
      'header'   => view('estrutura.header', $this->dadosLayout)->render(),
      'conteudo' => view('conteudo.' . $pagina, $this->dadosLayout)->render(),
      'footer'   => view('estrutura.footer', $this->dadosLayout)->render(),
      'debug'    => $layoutDebug
    ]);
  }
  
}