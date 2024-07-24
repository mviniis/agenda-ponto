<?php

namespace App\Models\Packages\Sistema\Handler;

use \DateTime;
use \DirectoryIterator;

/**
 * class Base
 * 
 * Classe responsável por manipular os arquivos de handler
 * 
 * @author Matheus Vinicius
 */
abstract class Base {
  /**
   * Define o caminho até onde é salvo os arquivos de handler
   */
  private const STORAGE = ROOT . '/storage/app/public/';

  /**
   * Define o caminho até onde estão os arquivos de estilização
   */
  private const RESOURCES = ROOT . '/resources/';

  /**
   * Caminho completo do arquivo de handler
   * @var string
   */
  private string $fullPathFile;

  /**
   * Define se o conteúdo do handler deve ser carregado
   * @var bool
   */
  private bool $permitirCarregarConteudo = false;
  
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
   * Método responsável por montar o caminho completo do handler
   * @return self
   */
  private function definirCaminhoCompleto(): self {
    $this->fullPathFile = self::STORAGE . $this->typeFile . '/' . $this->fileName;
    return $this;
  }

  /**
   * Método responsável por verificar e criar um arquivo handler
   * @return self
   */
  private function definirArquivoHandler(): self {
    if(!file_exists($this->fullPathFile)) {
      $this->salvarConteudo();
      $this->permitirCarregarConteudo = true;
    }
    return $this;
  }

  /**
   * Método responsável por salvar o conteúdo de um arquivo do handler
   * @param  string       $conteudo       Conteúdo do arquivo
   * @return void
   */
  private function salvarConteudo(string $conteudo = ''): void {
    file_put_contents($this->fullPathFile, $conteudo);
  }

  /**
   * Método responsável por carregar o conteúdo de um arquivo handler
   * @return self
   */
  private function carregarConteudo(): self {
    if(!$this->validarCarregamentoDeNovoConteudo()) return $this;
    
    // CARREGA O CONTEÚDO DOS ARQUIVOS VINCULADOS
    $conteudo = "";
    foreach($this->filesAndFolders as $path) {
      $fullPath  = self::RESOURCES . $this->typeFile . '/' . $path;
      $conteudo .= $this->carregarConteudoPorCaminho($fullPath);
    }

    // SALVA O CONTEÚDO
    $this->salvarConteudo($conteudo);

    return $this;
  }

  /**
   * Método responsável por carregar os dados dos arquivos pertencentes ao handler
   * @param  string       $caminho       Caminho do arquivo
   * @return string
   */
  private function carregarConteudoPorCaminho(string $caminho): string {
    $conteudo = '';
    try {
      if(is_dir($caminho)) {
        foreach(new DirectoryIterator($caminho) as $obArquivo) {
          if($obArquivo->isDir() || $obArquivo->isDot()) continue;
          $conteudo .= $this->carregarConteudoPorCaminho($obArquivo->getPathname());
        }
      } else {
        $conteudo = file_get_contents($caminho);
        if(strlen($conteudo)) $conteudo .= PHP_EOL . PHP_EOL;
      }
    } catch(\Exception $ex) {}

    return $conteudo;
  }

  /**
   * Método responsável por validar se deve ser carregado o conteúdo do arquivo de handler
   * @return bool
   */
  private function validarCarregamentoDeNovoConteudo(): bool {
    if($this->permitirCarregarConteudo) return true;

    // CARREGA AS CONFIGURAÇÕES
    $tempoMaximo       = (int) ($_ENV['APP_TIME_HANDLER'] ?? 0);
    $ultimaAtualizacao = new DateTime(date('Y-m-d H:i:s', filectime($this->fullPathFile)));
    $dataAtualServidor = new DateTime();

    // VALIDA SE O ARQUIVO NUNCA DEVE SER ATUALIZADO
    if($tempoMaximo <= 0) return false;

    // VERIFICA O SE PODE MODIFICAR O CONTEÚDO DO ARQUIVO
    $ultimaAtualizacao->modify("+{$tempoMaximo} minutes");

    // VALIDAÇÃO DO TEMPO DE MODIFICAÇÃO
    return $dataAtualServidor >= $ultimaAtualizacao;
  }

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
  public function defineHandlerFileName(string $name): self {
    $this->fileName = base64_encode($name) . '.' . $this->typeFile;
    return $this;
  }

  /**
   * Método responsável por definir os arquivos ou diretórios de arquivos de estilização
   * @param  array      $filesAndFolders      Arquivos e diretórios de estilização
   * @return self
   */
  public function setFilesAndFolders($files = []): self {
    $this->filesAndFolders = $files;
    return $this;
  }

  /**
   * Método responsável por retornar a url do arquivo de handler
   * @param  bool       $forcarAtualizacao       Forca a atualização do handler
   * @return string
   */
  public function getArquivoHandler(bool $forcarAtualizacao = false): string {
    $this->permitirCarregarConteudo = $forcarAtualizacao;
    $this->definirCaminhoCompleto()->definirArquivoHandler()->carregarConteudo();

    // RETORNA A URL DO ARQUIVO
    return "{$_ENV['APP_URL']}/storage/app/public/{$this->typeFile}/{$this->fileName}";
  }
}