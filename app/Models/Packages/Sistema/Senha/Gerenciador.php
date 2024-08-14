<?php

namespace App\Models\Packages\Sistema\Senha;

use \Exception;
use \Firebase\JWT\{JWT, Key};

/**
 * class Gerenciador
 * 
 * Classe responsável por realizar a manipulação das senha
 * 
 * @author Matheus Vinicius
 */
class Gerenciador {
  /**
   * Define o tipo do algorítimo da geração do JWT
   * @var string
   */
  private const ALGORITOMO_JWT = 'HS256';
  
  /**
   * Define a chave secreta para assinar e verificar o JWT
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

    // CRIA UM PAYLOAD COM A SENHA CRIPTOGRAFADA USANDO A PASSWORD HASH
    $payload = [
      'iat'          => time(),
      'passwordHash' => password_hash($senha, PASSWORD_DEFAULT),
    ];

    // REALIZA A GERAÇÃO DO TOKEN
    return JWT::encode($payload, self::CHAVE_SECRETA, self::ALGORITOMO_JWT);
  }

  /**
   * Método responsável por validar a senha
   * @param  string       $senha          Senha a ser verificada
   * @param  string       $jwtToken       Token JWT contendo o hash armazenado
   * @return bool
   */
  public static function validarSenha(string $senha, string $jwtToken): bool {
    try {
      // DECODIFICA O TOKEN
      $decoded      = JWT::decode($jwtToken, new Key(self::CHAVE_SECRETA, self::ALGORITOMO_JWT));
      $passwordHash = $decoded->passwordHash;

      // VERIFICA SE A SENHA CORRESPONSE A HASH ARMAZENADA
      return password_verify($senha, $passwordHash);
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Método responsável por realizar a validação de regras da senha
   * @param  string       $senha       Senha que será verificada
   * @return void
   */
  private static function validarParametrosSenha(string $senha): void {
    $quantidadeNumeros = self::QUANTIDADE_MINIMA_NUMEROS;
    $quantidadeLetras  = self::QUANTIDADE_MINIMA_LETRAS;

    if (strlen($senha) < 5) {
      throw new Exception("A senha deve ter pelo menos 5 caracteres.");
    }

    if (preg_match_all('/\d/', $senha) < $quantidadeNumeros) {
      throw new Exception("A senha deve ter pelo menos {$quantidadeNumeros} números.");
    }

    if (preg_match_all('/[a-zA-Z]/', $senha) < $quantidadeLetras) {
      throw new Exception("A senha deve ter pelo menos {$quantidadeLetras} letras.");
    }

    if (preg_match('/\s/', $senha)) throw new Exception("A senha não deve conter espaços.");
  }
}
