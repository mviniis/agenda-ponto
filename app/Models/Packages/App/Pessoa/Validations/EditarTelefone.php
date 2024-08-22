<?php

namespace App\Models\Packages\App\Pessoa\Validations;

use Exception;

/**
 * class EditarTelefone
 * 
 * Classe responsável por validar a edição do telefone
 * 
 * @author Matheus Vinicius
 */
class EditarTelefone {
  /**
   * Construtor da classe
   * @param string      $telefoneContato          Telefone de contato
   * @param string      $telefoneCelular          Telefone celular
   * @param string      $telefoneResidencial      Telefone residencial
   */
  public function __construct(
    private string $telefoneContato,
    private ?string $telefoneCelular = null,
    private ?string $telefoneResidencial = null,
  ) {}

  /**
   * Método responsável por realizar a validação de um telefone de contato
   * @return self
   */
  public function validarTelefoneContatoUsuarioLogado(): self {
    if(!$this->validarTelefoneCelular($this->telefoneContato) && !$this->validarTelefoneFixo($this->telefoneContato)) {
      throw new Exception('O telefone de contato informado é inválido.', 400);
    }

    $this->telefoneContato = $this->getNumerosTelefone($this->telefoneContato);
    return $this;
  }

  /**
   * Método responsável por obter o telefone de contato
   * @return string
   */
  public function getTelefoneContato(): string {
    return $this->telefoneContato;
  }

  /**
   * Método responsável por obter somente os valores numéricos de um telefone
   * @param  string       $telefone       Telefone que será validado
   * @return string
   */
  private function getNumerosTelefone(string $telefone): string {
    return preg_replace('/[^\d]/', '', $telefone);
  }

  /**
   * Método responsável por validar se o telefone celular é válido
   * @param  string       $telefone       Telefone que será validado
   * @return bool
   */
  private function validarTelefoneCelular(string $telefone): bool {
    // VERIFICA SE O TELEFONE ESTÁ COM A MÁSCARA CORRETA
    if(!((bool) preg_match('/\(?\d{2,3}\)?\s?\d{5}-?\d{4}/', $telefone))) return false;

    // VERIFICA SE A QUANTIDADE DE CARACTERES É VÁLIDA
    $auxTelefone = $this->getNumerosTelefone($telefone);
    return (strlen($auxTelefone) == 12) || (strlen($auxTelefone) == 11);
  }

  /**
   * Método responsável por validar se o telefone fixo é válido
   * @param  string       $telefone       Telefone que será validado
   * @return bool
   */
  private function validarTelefoneFixo(string $telefone): bool {
    // VERIFICA SE O TELEFONE ESTÁ COM A MÁSCARA CORRETA
    if(!((bool) preg_match('/\(?\d{2,3}\)?\s?\d{4}-?\d{4}/', $telefone))) return false;

    // VERIFICA SE A QUANTIDADE DE CARACTERES É VÁLIDA
    $auxTelefone = $this->getNumerosTelefone($telefone);
    return (strlen($auxTelefone) == 11) || (strlen($auxTelefone) == 10);
  }
}