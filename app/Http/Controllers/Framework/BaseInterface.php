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

  /**
   * Método responsável por realizar a atualização dos arquivos de estilização e scripts da página
   * @param  bool       $forcarAtualizacao       Forca a atualização do conteúdo dos arquivos handlers de uma página
   * @return void
   */
  public function atualizarHandlers(bool $forcarAtualizacao = false): void;

  /**
   * Método responsável por retornar o conteúdo renderizado de uma página
   * @param  string       $pagina       Nome da página
   * @return string
   */
  public function getConteudo(string $pagina): mixed;
}