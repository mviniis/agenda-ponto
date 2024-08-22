<?php

namespace App\Http\Controllers\App\Usuario;

use \Illuminate\Http\Request;
use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \App\Models\Packages\App\Pessoa\Validations\{EditarPessoa, EditarTelefone};
use \App\Models\DTOs\{PessoaDTO, PessoaFisicaDTO, PessoaJuridicaDTO, PessoaTelefoneDTO};
use \App\Models\Packages\App\Pessoa\Actions\{PessoaAction, PessoaFisicaAction, PessoaJuridicaAction, PessoaTelefoneAction};

/**
 * class Post
 * 
 * Classe responsável por controlar as requisições POST da página de atualização do perfil do usuário
 * 
 * @author Matheus Vinicius
 */
class Post extends Base {
  public function configure(): self {
    return $this;
  }

  /**
   * Método responsável por realizar a validação da requisição de atualização do perfil de usuário
   * @param  Request      $request      Dados da requisição
   * @return string
   */
  public function atualizar(Request $request) {
    $status           = true;
    $mensagem         = 'Dados alterados com sucesso!';
    $codigoRequisicao = 200;

    try {
      // VALIDAÇÃO DA PESSOA
      $obValidacaoPessoa = (new EditarPessoa(
        (string) $request->email,
        (string) $request->nome, 
        (string) $request->sobrenome
      ))->definirIdsUsuarioLogado()->definirTipoPessoaUsuarioLogado()->validarEmailUsuarioLogado()->validarNomes();

      // VALIDAÇÃO DO TELEFONE
      $obValidacaoTelefone = (new EditarTelefone((string) $request->telefone))->validarTelefoneContatoUsuarioLogado();

      // MONTA O DTO DE PESSOA
      $obPessoaDTO        = new PessoaDTO;
      $obPessoaDTO->id    = $obValidacaoPessoa->getIdPessoa();
      $obPessoaDTO->email = $request->email;

      // MONTA O DTO DO TIPO DE PESSOA
      $obTipoPessoaDTO = null;
      switch($obValidacaoPessoa->getTipoPessoaFisica()) {
        case true:
          $obTipoPessoaDTO            = new PessoaFisicaDTO;
          $obTipoPessoaDTO->idPessoa  = $obValidacaoPessoa->getIdPessoa();
          $obTipoPessoaDTO->nome      = $request->nome;
          $obTipoPessoaDTO->sobrenome = $request->sobrenome;
          break;
        
        default:
          $obTipoPessoaDTO               = new PessoaJuridicaDTO();
          $obTipoPessoaDTO->idPessoa     = $obValidacaoPessoa->getIdPessoa();
          $obTipoPessoaDTO->razaoSocial  = $request->nome;
          $obTipoPessoaDTO->nomeFantasia = $request->sobrenome;
          break;
      }

      // MONTA O OBJETO DO TELEFONE
      $obPessoaTelefoneDTO                  = new PessoaTelefoneDTO;
      $obPessoaTelefoneDTO->idPessoa        = $obValidacaoPessoa->getIdPessoa();
      $obPessoaTelefoneDTO->telefoneContato = $obValidacaoTelefone->getTelefoneContato();

      // REALIZA AS ATUALIZAÇÕES
      (new PessoaAction)->atualizarEmailPessoa($obPessoaDTO);
      (new PessoaTelefoneAction)->atualizarTelefones($obPessoaTelefoneDTO);
      $obAction = ($obValidacaoPessoa->getTipoPessoaFisica()) ? new PessoaFisicaAction: new PessoaJuridicaAction;
      $obAction->atualizarPessoa($obTipoPessoaDTO);
      
      // SALVA OS DADOS NA SESSÃO
      $obSessao            = new UsuarioSessao;
      $hashSessaoNome      = ($obValidacaoPessoa->getTipoPessoaFisica()) ? ['nome']     : ['razaoSocial'];
      $hashSessaoSobrenome = ($obValidacaoPessoa->getTipoPessoaFisica()) ? ['sobrenome']: ['nomeFantasia'];
      $obSessao->atualizarCampo(['login', 'email'], $obPessoaDTO->email);
      $obSessao->atualizarCampo(array_merge(['dadosPessoais'], $hashSessaoNome), $obTipoPessoaDTO->nome);
      $obSessao->atualizarCampo(array_merge(['dadosPessoais'], $hashSessaoSobrenome), $obTipoPessoaDTO->sobrenome);
      $obSessao->atualizarCampo(array_merge(['dadosPessoais'], ['telefone']), $obPessoaTelefoneDTO->telefoneContato);
    } catch (\Exception $ex) {
      $status           = false;
      $mensagem         = $ex->getMessage();
      $codigoRequisicao = $ex->getCode();
    }

    return response()->json([
      'status'   => $status,
      'mensagem' => $mensagem
    ], $codigoRequisicao);
  }
}