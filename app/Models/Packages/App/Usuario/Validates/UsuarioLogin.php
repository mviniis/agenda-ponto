<?php

namespace App\Models\Packages\App\Usuario\Validates;

use \Exception;
use \App\Models\DTOs\UsuarioDTO;
use \App\Models\Packages\Sistema\Senha\Gerenciador;
use \App\Models\Packages\App\Usuario\Actions\UsuarioAction;

/**
 * class UsuarioLogin
 * 
 * Classe responsável por realizar a validação do login de um usuário
 * 
 * @author Matheus Vinicius
 */
class UsuarioLogin {
  /**
   * Guarda os dados do usuário já validado
   * @var UsuarioDTO
   */
  private ?UsuarioDTO $obUsuario;
  
  /**
   * Construtor da classe
   * @param string      $email      E-mail do usuário que está realizando o login
   * @param string      $senha      Senha do usuário que está realizando o login
   */
  public function __construct(
    private string $email,
    private ?string $senha = null,
  ) {}

  /**
   * Método responsável por centralizar as chamadas das validações do login do usuário
   * @return self
   */
  public function validar(): self {
    $this->validarEmail()->validarSenha()->validarExistenciaUsuario();

    return $this;
  }

  /**
   * Método responsável por retornar os dados do usuário validado
   * @return UsuarioDTO
   */
  public function getUsuarioValido(): UsuarioDTO {
    if(!$this->obUsuario instanceof UsuarioDTO) {
      throw new Exception('Não existe nenhum dado de usuário válido.', 406);
    }

    return $this->obUsuario;
  }

  /**
   * Método responsável por realizar a validação do e-mail do usuário informado
   * @return self
   */
  private function validarEmail(): self {
    // REMOVE OS ESPAÇOS EM BRANCO
    $email = str_replace(' ', '', $this->email);

    // VERIFICA SE O E-MAIL É VÁLIDO
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("O e-mail informado é inválido", 400);
    }

    return $this;
  }

  /**
   * Método responsável por realizar a validação da senha
   * @return self
   */
  private function validarSenha(): self {
    if(is_null($this->senha)) throw new Exception('É necessário informar uma senha válida.', 404);

    // VALIDA OS PARÂMETROS DA SENHA
    Gerenciador::validarParametrosSenha($this->senha);

    // CRIPTOGRAFA A SENHA
    $this->senha = Gerenciador::criptografarSenha($this->senha);
    return $this;
  }

  /**
   * Método responsável por verificar se o usuário existe na base de dados
   * @return self
   */
  private function validarExistenciaUsuario(): self {
    $obEntity = (new UsuarioAction)->getUsuarioPorCredenciaisLogin(
      $this->email, $this->senha
    );

    // VERIFICA SE A CONSULTA FOI BEM SUCEDIDA
    if(!$obEntity->getSuccess()) {
      throw new Exception(
        'Não foi encontrado nenhum usuário com as credenciais informada. Experimente realizar o cadastro.', 
        404
      );
    }

    // SALVA OS DADOS DO USUÁRIO
    $this->obUsuario = $obEntity->getData();

    return $this;
  }
}