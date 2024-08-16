<?php

namespace App\Http\Controllers\App\Inicio;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \App\Models\Packages\App\Usuario\Validates\UsuarioLogin;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de início do site (login do usuário)
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de login
   * @param  Request      $request      Dados da requisição
   * @return json
   */
  public function efetuarLogin(Request $request) {
    $status           = true;
    $mensagem         = 'Login efetuado com sucesso! Você será redirecionado.';
    $codigoRequisicao = 200;

    try {
      $obUsuarioLogin = new UsuarioLogin((string) $request->email, $request->senha);

      // SALVA OS DADOS DO USUÁRIO NA SESSÃO
      (new UsuarioSessao)->finalizarLogin($obUsuarioLogin->validar()->getUsuarioValido());
    } catch(\Exception $ex) {
      $status           = false;
      $mensagem         = $ex->getMessage();
      $codigoRequisicao = $ex->getCode();
    }

    return response()->json([
      'status'   => $status,
      'mensagem' => $mensagem
    ], $codigoRequisicao);
  }

  /**
   * Método responsável por realizar o logout de um usuário logado
   * @return json
   */
  public function efetuarLogout() {
    (new UsuarioSessao)->removerSessaoUsuario();

    return response()->json([
      'status'   => true,
      'mensagem' => 'Logout efetuado com sucesso!'
    ]);
  }
}