<?php

namespace App\Http\Controllers\App\Cadastro;

use \Exception;
use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\App\Pessoa\Actions\PessoaAction;
use App\Models\Packages\App\Pessoa\Actions\PessoaFisicaAction;
use App\Models\Packages\App\Pessoa\Actions\PessoaJuridicaAction;
use App\Models\Packages\App\Pessoa\Actions\PessoaTelefoneAction;
use \App\Models\Packages\App\Usuario\Validates\UsuarioLogin;
use \App\Models\Packages\App\Pessoa\Validations\{EditarTelefone, CadastrarPessoa};
use App\Models\Packages\App\Usuario\Actions\UsuarioAction;

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de cadastro de usuário
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
   * @return string
   */
  public function cadastrarUsuario(Request $request) {
    $dadosEnviados = $request->dadosEnviar;
    $codigoHttp    = 200;
    $response      = [
      'status'   => true,
      'mensagem' => 'Cadastro efetuado com sucesso! Realize agora o seu primeiro login.'
    ];

    try {
      $obValidacaoPessoa   = new CadastrarPessoa($dadosEnviados['pessoa']);
      $obValidacaoTelefone = new EditarTelefone($dadosEnviados['telefone'] ?? '');
      $obValidacaoUsuario  = new UsuarioLogin(senha: $dadosEnviados['usuario']['senha'] ?? '');

      // REALIZA AS VALIDAÇÕES
      $obValidacaoPessoa->validarEmail()->validarDocumento()->validarNomes();
      $obValidacaoTelefone->validarNovoTelefoneContato();
      $obValidacaoUsuario->validarSenha();

      // MONTA OS DTOS
      $obPessoaDTO         = $obValidacaoPessoa->getObjetoDtoPessoa();
      $obPessoaTipoDTO     = $obValidacaoPessoa->getObjetoDtoPorTipoPessoa();
      $obUsuarioDTO        = $obValidacaoUsuario->getObjetoDtoUsuario();
      $obPessoaTelefoneDTO = $obValidacaoTelefone->getObjetoDtoTelefone();
      
      // REALIZA O SALVAMENTO DAS INFORMAÇÕES
      (new PessoaAction)->salvar($obPessoaDTO);
      if(!is_numeric($obPessoaDTO->id)) {
        throw new Exception('Não foi posssível realizar o seu cadastro. Tente novamente mais tarde');
      }

      // SALVA O ID DA PESSOA QUE FOI CRIADA
      $obUsuarioDTO->idPessoa        = $obPessoaDTO->id;
      $obPessoaTipoDTO->idPessoa     = $obPessoaDTO->id;
      $obPessoaTelefoneDTO->idPessoa = $obPessoaDTO->id;

      // SALVA AS DEMAIS INFORMAÇÕES
      (new UsuarioAction)->salvar($obUsuarioDTO);
      (new PessoaTelefoneAction)->salvar($obPessoaTelefoneDTO);
      $obAction = $obValidacaoPessoa->isPessoaFisica() ? new PessoaFisicaAction: new PessoaJuridicaAction;
      $obAction->salvar($obPessoaTipoDTO);
    } catch(Exception $ex) {
      $codigoHttp           = $ex->getCode();
      $response['status']   = false;
      $response['mensagem'] = $ex->getMessage();
    }

    return response()->json($response, $codigoHttp);
  }
}