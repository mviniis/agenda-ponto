<?php

namespace App\Models\Packages\App\Usuario\Sessao;

use \App\Models\Packages\Sistema\Sessao\SessionManager;

/**
 * class UsuarioSessao
 * 
 * Classe responsável por realizar a manipulação dos dados do usuário na sessão
 * 
 * @author Matheus Vinicius
 */
class UsuarioSessao {
  /**
   * Guarda o objeto de manipução da sessão do usuário
   * @var SessionManager
   */
  private SessionManager $obSession;

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->obSession = (new SessionManager(['usuario']));
  }

  /**
   * Método responsável por realizar a criação da sessão do usuário
   * @return self
   */
  public function criarSessaoUsuario(): self {
    $hashLogin = ['login'];
    if(is_null($this->obSession->get($hashLogin))) {
      $this->obSession->set($hashLogin, []);
    }

    $hashDadosPessoais = ['dadosPessoais'];
    if(is_null($this->obSession->get($hashDadosPessoais))) {
      $this->obSession->set($hashDadosPessoais, []);
    }

    return $this;
  }

  /**
   * Método responsável por verificar se o usuário está logado
   * @return bool
   */
  public function usuarioEstaLogado(): bool {
    $dados = $this->obSession->get(['login', 'id']);
    return !is_null($dados) && !empty($dados);
  }

  /**
   * Método responsável por remover a sessão do usuário
   * @return bool
   */
  public function removerSessaoUsuario(): bool {
    return $this->obSession->remove();
  }
}