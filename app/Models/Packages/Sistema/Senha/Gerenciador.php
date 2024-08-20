<?php

namespace App\Models\Packages\Sistema\Senha;

use \Exception;

/**
 * class Gerenciador
 * 
 * Classe responsável por realizar a manipulação das senha
 * 
 * REGRAS DA IMPLEMENTAÇÃO DA SENHA:
 *  - Mínimo de 5 caracteres
 *  - Mínimo de 3 letras
 *  - Mínimo de 3 números
 *  - Não pode possuir espaços
 * 
 * @author Matheus Vinicius
 */
class Gerenciador {
  /**
   * Chave secreta para ser utilizada como "salt".
   * @var string
   */
  private const CHAVE_SECRETA = 'vX8kkqQAcgsonyXvGp6tVUVex3v4YJz5';

  /**
   * Define a quantidade mínima de números na senha
   * @var int
   */
  private const QUANTIDADE_MINIMA_NUMEROS = 3;

  /**
   * Define a quantidade mínima de letras na senha
   * @var int
   */
  private const QUANTIDADE_MINIMA_LETRAS = 3;

  /**
   * Método responsável por gerar um hash JWT para a senha fornecida
   * @param  string       $senha       Senha a ser criptografada
   * @return string
   */
  public static function criptografarSenha(string $senha): string {
    self::validarParametrosSenha($senha);
    return hash('sha256', self::CHAVE_SECRETA . $senha);
  }

  /**
   * Método responsável por realizar a validação de regras da senha
   * @param  string       $senha       Senha que será verificada
   * @return void
   */
  public static function validarParametrosSenha(string $senha): void {
    $quantidadeNumeros = self::QUANTIDADE_MINIMA_NUMEROS;
    $quantidadeLetras  = self::QUANTIDADE_MINIMA_LETRAS;
    $codigoHttpErro    = 406;

    if (strlen($senha) < 5) {
      throw new Exception("A senha deve ter pelo menos 5 caracteres.", $codigoHttpErro);
    }

    if (preg_match_all('/\d/', $senha) < $quantidadeNumeros) {
      throw new Exception("A senha deve ter pelo menos {$quantidadeNumeros} números.", $codigoHttpErro);
    }

    if (preg_match_all('/[a-zA-Z]/', $senha) < $quantidadeLetras) {
      throw new Exception("A senha deve ter pelo menos {$quantidadeLetras} letras.", $codigoHttpErro);
    }

    if (preg_match('/\s/', $senha)) throw new Exception("A senha não deve conter espaços.", $codigoHttpErro);
  }
}
