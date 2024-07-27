<?php

namespace App\Models\Packages\Sistema\Paginacao;

/**
 * class Paginacao
 * 
 * Classe responsável por manipular e montar uma paginação
 * 
 * @author Matheus Vinicius
 */
class Paginacao {
  /**
   * Guarda as paginações que serão retornadas
   * @var array
   */
  private array $paginas = [];

  /**
   * Filtros aplicados a listagem
   * @var array
   */
  private array $filtros = [];

  /**
   * Construtor da classe de paginação
   * @param int         $totalRegistros          Total de registros da listagem
   * @param int         $itensPorPagina          Quantiadade de itens que serão exibidas por página
   * @param int         $paginaAtual             Define qual a página que está sendo acessada
   */
  public function __construct(
    private int $totalRegistros, 
    private int $itensPorPagina, 
    private int $paginaAtual
  ) {
    $this->filtros = $_GET;
  }

  /**
   * Método responsável por gerar a paginação
   * @return array
   */
  public function generate(): array {
    $totalPaginas = ceil($this->totalRegistros / $this->itensPorPagina);
    if($totalPaginas == 0 || $this->paginaAtual >= $totalPaginas) return [];

    // ADICIONA A PRIMEIRA PÁGINA
    if($totalPaginas == 1) {
      $this->addItem(1, 0, true);
      return $this->paginas;
    }
    
    if($totalPaginas <= 5) {
      for($i = 0; $i < $totalPaginas; $i++) {
        $this->addItem(($i + 1), $i);
      }

      return $this->paginas;
    }
    
    // DEFINE QUANTAS PÁGINAS EXISTIRÃO
    $itensPaginas = [];
    for($i = 0; $i < $totalPaginas; $i++) {
      $itensPaginas[] = $i;
    }

    // VALIDAÇÃO DAS POSIÇÕES
    $indice = array_search($this->paginaAtual, $itensPaginas);
    switch(true) {
      case $indice == 0:
      case $indice == 1:
      case $indice == 2:
        $this->addItem('first', 0, true);
        $this->addItem(1, 0);
        $this->addItem(2, 1);
        $this->addItem(3, 2);
        $this->addItem('last', ($totalPaginas - 1));
      break;

      case $indice == ($totalPaginas - 1):
      case $indice == ($totalPaginas - 2):
      case $indice == ($totalPaginas - 3):
        $this->addItem('first', 0);
        $this->addItem(($totalPaginas - 2), ($totalPaginas - 3));
        $this->addItem(($totalPaginas - 1), ($totalPaginas - 2));
        $this->addItem(($totalPaginas), ($totalPaginas - 1));
        $this->addItem('last', ($totalPaginas - 1), true);
      break;

      default:
        $this->addItem('first', 0);
        $this->addItem(($this->paginaAtual), ($this->paginaAtual - 1));
        $this->addItem(($this->paginaAtual + 1), ($this->paginaAtual));
        $this->addItem(($this->paginaAtual + 2), ($this->paginaAtual + 1));
        $this->addItem('last', ($totalPaginas - 1));
      break;
    }

    return $this->paginas;
  }

  /**
   * Método responsável por adicionar um item nas paginações que serão retornadas
   * @param  int|string        $label              Label do item atual
   * @param  int               $numeroPagina       Número da página atual
   * @param  bool              $desabilitar        Define se a página será desabilitada
   * @return void
   */
  private function addItem(mixed $label, int $numeroPagina, bool $desabilitar = false): void {
    $this->paginas[] = [
      'page'     => $label,
      'url'      => $this->getPageUrl($numeroPagina, $this->getBaseUrl()),
      'active'   => $numeroPagina === $this->paginaAtual,
      'disabled' => $desabilitar,
    ];
  }

  /**
   * Método responsável por montar a URL de consulta de um item
   * @return string
   */
  private function getBaseUrl(): string {
    $parametors = $this->filtros;
    unset($parametors['pagina']);

    $url = $_ENV['APP_URL'] . '?' . http_build_query($parametors);
    if(!empty($parametors)) $url .= '&';

    return $url;
  }

  /**
   * Método responsável por adicionar o número da página na URL do item
   * @param  int          $page          Número da página que está sendo processada
   * @param  string       $baseUrl       URL base para a URL do item
   * @return string
   */
  private function getPageUrl(int $page, string $baseUrl): string {
    return $baseUrl . 'pagina=' . $page;
  }
}
