<?php

namespace App\Models\Packages\Sistema\Sessao;

/**
 * class SessionManager
 * 
 * Classe responsável por realizar a manipulação da sessão
 * 
 * @author Matheus Vinicius
 */
class SessionManager {
  /**
   * Define a hash base da sessão manipulada
   * @var array
   */
  private array $sessionHash;

  /**
   * Método responsável por iniciar a sessão
   * @return void
   */
  public static function init(): void {
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  }

  /**
   * Construtor da classe
   * @param array       $sessionHash       Hash da sessão
   */
  public function __construct(array $sessionHash = []) {
    $hashBase = array_merge([$_ENV['APP_KEY']], $sessionHash);
    $this->formatarHashSessao($hashBase);
    $this->sessionHash = $hashBase;
  }

  /**
   * Método responsável por gravar um dado na sessão
   * @param  array      $hash       Hash da sessão onde será adicionado o valor
   * @param  mixed      $value      Valor que será adicionado
   * @return bool
   */
  public function set(array $hash = [], mixed $value = null): bool {
    if(is_null($value)) return false;

    $hashItem = $this->adicionarHashComplementar($hash);
    $_SESSION = $this->adicionarValoresSessao($hashItem, $_SESSION, $value);
    return true;
  }

  /**
   * Método responsável por obter os dados de um indice da sessão por uma array
   * @param  array      $hash       Hash da sessão onde será consultado o valor
   * @return mixed
   */
  public function get(array $hash): mixed {
    if(empty($hash)) return null;

    $hashItem = $this->adicionarHashComplementar($hash);
    $valor    = $this->buscarValorNaSessao($hashItem, $_SESSION);

    return $valor;
  }

  /**
   * Método responsável por remover os dados de um índice da sessão
   * @param  array      $hash       Hash do índice da sessão que será removido
   * @return bool
   */
  public function remove(array $hash): bool {
    if(empty($hash)) return false;

    $hashItem = $this->adicionarHashComplementar($hash);
    return $this->removerValorDaSessao($hashItem, $_SESSION);
  }
  
  /**
   * Método responsável por retornar todos os dados gravados na sessão
   * @return array
   */
  public function getAll(): array {
    $hashSession = [$_ENV['APP_KEY']];
    $this->formatarHashSessao($hashSession);
    $hash = $hashSession[0] ?? 'none';
    return $_SESSION[$hash] ?? [];
  }

  /**
   * Método responsável por resetar a sessão
   * @return void
   */
  public function clear(): void {
    session_unset();
    session_destroy();
  }

  /**
   * Método responsável por centralizar a lógica da adição de um valor na sessão
   * @param  array      $hash        Hash da sessão que será adicionada
   * @param  array      $sessao      Dados da sessão
   * @param  mixed      $valor       Valor que será inserido
   * @return mixed
   */
  private function adicionarValoresSessao(array $hash, array $sessao, mixed $valor): mixed {
    if(empty($hash)) return $valor;

    // PEGA O ITEM PARA SER VALIDADO
    $hashAtual = array_shift($hash);

    // CRIA A SESSÃO CASO NÃO EXISTA
    if(!isset($sessao[$hashAtual])) $sessao[$hashAtual] = [];

    // EVITA DE TENTAR CRIAR UM ÍNDICE EM UM VALOR SIMPLES
    if(!is_array($sessao[$hashAtual])) return $sessao;

    // VERIFICA SE AINDA EXISTEM HASHES A SEREM ADICIONADAS
    $sessao[$hashAtual] = $this->adicionarValoresSessao($hash, $sessao[$hashAtual], $valor);

    return $sessao;
  }

  /**
   * Método responsável por buscar um dado na sessão
   * @param  array      $hash        Hash da sessão que será consultada
   * @param  array      $sessao      Dados da sessão
   * @return mixed
   */
  private function buscarValorNaSessao(array $hash, array $sessao): mixed {
    if(empty($hash)) return null;
    
    // VERIFICA SE A HASH EXISTE
    $hashAtual = array_shift($hash);
    if(!isset($sessao[$hashAtual])) return null;

    // REALIZA MAIS UMA RECURSÃO
    if(is_array($sessao[$hashAtual]) && !empty($hash)) {
      return $this->buscarValorNaSessao($hash, $sessao[$hashAtual]);
    }

    return $sessao[$hashAtual];
  }

  /**
   * Método responsável por realizar a remoção de um dado da sessão
   * @param  array      $hash        Hash da sessão que será removida
   * @param  array      $sessao      Dados da sessão
   * @return bool
   */
  private function removerValorDaSessao(array $hash, array &$sessao): bool {
    if(empty($hash)) return false;

    $hashAtual = array_shift($hash);
    if (!isset($sessao[$hashAtual])) return false;

    // VERIFICA SE POSSUI MAIS ALGUM NÍVEL PARA SER VALIDADO
    if(!empty($hash)) {
      $removido = $this->removerValorDaSessao($hash, $sessao[$hashAtual]);
      
      // VERIFICA SE O ARRAY DE SESSÃO ATUAL ESTÁ VAZIO
      if($removido && empty($sessao[$hashAtual])) unset($sessao[$hashAtual]);

      return $removido;
    }
    
    unset($sessao[$hashAtual]);
    return true;
  }

  /**
   * Método responsável por gerar a hash completa da sessão
   * @param  array      $hashAdicional      Hash adicional a hash base da sessão
   * @return array
   */
  private function adicionarHashComplementar(array $hashAdicional): array {
    $this->formatarHashSessao($hashAdicional);
    return array_merge($this->sessionHash, $hashAdicional);
  }

  /**
   * Método responsável por realizar a formatação de uma hash de sessão
   * @param  array      $hash        Hash da sessão
   * @return self
   */
  private function formatarHashSessao(array &$hash): self {
    foreach($hash as &$itemHash) {
      $itemHash = str_replace([' ', '-', ':', '='], '_', $itemHash);
      $itemHash = str_replace(['<', '>', "'", '"', '!', '*', '(', ')', ';', '\\', "\n", "\t"], '', $itemHash);
    }

    return $this;
  }
}