<?php

namespace App\Models\Packages\App\RecuperacaoSenha\Validates;

use \Exception;
use \App\Models\Packages\App\Pessoa\Actions\PessoaAction;

/**
 * class RecuperarSenhaValidacoes
 * 
 * Classe responsável por realizar as validações da recuperação de senha
 * 
 * @author Matheus Vinicius
 */
class RecuperarSenhaValidacoes {
  /**
   * Construtor da classe
   * @param string      $email       E-mail do usuário que está recuperando a senha
   * @param string      $codigo      Código enviado na recuperação de senha
   */
  public function __construct(
    private ?string $email = null,
    private ?string $codigo = null
  ) {}

  /**
   * Método responsável por validar se o e-mail é válido
   * @return self
   */
  public function validarEmail(): self {
    $emailInformado = !is_null($this->email);
    $emailValido    = filter_var($this->email, FILTER_VALIDATE_EMAIL);
    if(!$emailInformado || !$emailValido) {
      throw new Exception('O e-mail informado é inválido.', 400);
    }

    // VERIFICA SE O E-MAIL FOI CADASTRADO
    if(!(new PessoaAction)->verificarDuplicidadeEmail($this->email)) {
      throw new Exception('E-mail não encontrado! Considere realizar o seu cadastro.', 406);
    }

    return $this;
  }

  /**
   * Método responsável por realziar a geração de um código de verificação
   * @return string
   */
  public function gerarCodigoDeValidacao(): string {
    return rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
  }
}