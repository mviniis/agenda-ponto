<?php

namespace App\Http\Controllers\App\Recuperacao;

use \Exception;
use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\App\Pessoa\Actions\PessoaAction;
use \App\Models\Packages\App\RecuperacaoSenha\{
  Sessao\RecuperarSenhaSessao,
  Actions\RecuperarSenhaAction,
  Validates\RecuperarSenhaValidacoes
};

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de recuperação de senha do usuário
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição da recuperação de senha
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function recuperarSenha(Request $request) {
    $email       = $request->email;
    $obValidacao = new RecuperarSenhaValidacoes($email);
    $codigoHttp  = 200;
    $response    = [
      'status'   => true,
      'mensagem' => 'Enviamos um e-mail para você com o código de verificação'
    ];

    try {
      $codigoVerificacao = $obValidacao->validarEmail()->gerarCodigoDeValidacao();

      // BUSCA OS DADOS DO USUÁRIO
      $obDadosPessoa = (new PessoaAction)->getDadosPessoaPorEmail($email);
      if(!$obDadosPessoa->getSuccess()) {
        throw new Exception('Não foi possível obter os seus dados, tente novamente mais tarde', 500);
      }

      // GERA UM NOVO CÓDIGO
      $obAction = new RecuperarSenhaAction;
      $obCodigo = $obAction->gerarCodigoConfirmacao($obDadosPessoa->getData(), $codigoVerificacao);
      if(!$obCodigo->getSuccess()) {
        throw new Exception('Não foi possível gerar o código de verificação. Tente novamente mais tarde.', 500);
      }

      // ENVIA O E-MAIL
      if(!$obAction->enviarEmailCodigoConfirmacao($obDadosPessoa->getData(), $obCodigo->getData())) {
        throw new Exception('Não foi enviar o e-mail no momento. Tente novamente mais tarde.', 500);
      }

      // SALVA OS DADOS NA SESSÃO
      (new RecuperarSenhaSessao)->salvarCodigoConfirmacaoSessao($obCodigo->getData());
    } catch(Exception $ex) {
      $codigoHttp           = $ex->getCode();
      $response['status']   = false;
      $response['mensagem'] = $ex->getMessage();
    }

    return response()->json($response, $codigoHttp);
  }

  /**
   * Método responsável por realizar a validação da requisição da segunda etapa recuperação de senha
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function validarSegundaParte(Request $request) {
    $obValidacao = new RecuperarSenhaValidacoes(codigo: $request->codigo);
    $codigoHttp  = 200;
    $response    = [
      'status'   => true,
      'mensagem' => 'Verificação efetuada com sucesso. Você será redirecionado para redefinir sua senha.'
    ];

    try{
      $obValidacao->verificarExistenciaSessao()
                  ->validarDataExpiracao()
                  ->validarCodigoConfirmacao()
                  ->adicionarIndiceUltimaEtapa();
    } catch(Exception $ex) {
      $codigoHttp           = $ex->getCode();
      $response['status']   = false;
      $response['mensagem'] = $ex->getMessage();
    }

    return response()->json($response, $codigoHttp);
  }
}