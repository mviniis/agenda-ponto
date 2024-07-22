<?php

namespace App\Models\Packages\Sistema\Handler;

/**
 * class Base
 * 
 * Classe responsável por manipular os arquivos de handler
 * 
 * @author Matheus Vinicius
 */
abstract class Base {
  /**
   * Guarda o nome do arquivo de handler que será gerado
   * @var string
   */
  private string $fileName;

  /**
   * Tipo da extensão do arquivo de handler
   * @var string
   */
  private string $typeFile;

  /**
   * Arquivos e diretórios de estilização
   * @var array
   */
  private array $filesAndFolders = [];

  /**
   * Método responsável por definir a extensão do arquivo de handler que será gerado
   * @param string      $typeFile      Tipo da extensão do arquivo de handler
   * @return self
   */
  protected function definirTipoDoArquivo(string $tipo): self {
    $this->typeFile = $tipo;
    return $this;
  }

  /**
   * Método responsável por definir o nome do arquivo de handler
   * @param   string      $name      Nome do arquivo de handler
   * @return self
   */
  protected function defineHandlerFileName(string $name): self {
    $this->fileName = base64_encode($name);
    return $this;
  }

  /**
   * Método responsável por definir os arquivos ou diretórios de arquivos de estilização
   * @param  array      $filesAndFolders      Arquivos e diretórios de estilização
   * @return self
   */
  public function setFilesAndFolders($files): self {
    $this->filesAndFolders = $files;
    return $this;
  }
}