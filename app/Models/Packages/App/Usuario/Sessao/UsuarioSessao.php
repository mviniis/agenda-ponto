<?php

namespace App\Models\Packages\App\Usuario\Sessao;

use \App\Models\DTOs\{UsuarioDTO, PessoaFisicaDTO};
use \App\Models\Packages\Sistema\Sessao\SessionManager;
use \App\Models\Packages\App\Pessoa\Actions\{PessoaAction, PessoaFisicaAction, PessoaJuridicaAction, PessoaTelefoneAction};

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
   * Métod responsável por retornar o ID do usuário logado
   * @return integer
   */
  public function getIdUsuarioLogado(): int {
    return $this->obSession->get(['login', 'id']) ?? 0;
  }

  /**
   * Métod responsável por retornar o tipo da pessoa do usuário logado
   * @return integer
   */
  public function getTipoPessoaUsuarioLogado(): string {
    return $this->obSession->get(['dadosPessoais', 'tipoPessoa']) ?? 'física';
  }

  /**
   * Método responsável por verificar se o usuário é do tipo pessoa física
   * @return bool
   */
  public function tipoUsuarioPessoaFisica(): bool {
    return $this->getTipoPessoaUsuarioLogado() == 'fisica';
  }

  /**
   * Método responsável por retornar os dados do login do usuário
   * @return array
   */
  public function getDadosLogin(): array {
    return $this->obSession->get(['login']) ?? [];
  }

  /**
   * Método responsável por retornar os dados pessois do usuário logado
   * @return array
   */
  public function getDadosPessoais(): array {
    return $this->obSession->get(['dadosPessoais']) ?? [];
  }

  /**
   * Método responsável por atualizar os dados de um campo específico da sessão de usuário
   * @param  array      $hash       Hash da sessão que será alterado
   * @param  mixed      $valor      Valor que será adicionado
   * @return void
   */
  public function atualizarCampo(array $hash, mixed $valor): void {
    if(is_null($valor)) return;
    $this->obSession->remove($hash);
    $this->obSession->set($hash, $valor);
  }

  /**
   * Método responsável por realizar o login de um usuário
   * @param  UsuarioDTO       $obUsuario       Dados do usuário válido
   * @return void
   */
  public function finalizarLogin(UsuarioDTO $obUsuario): void {
    $dadosPessoais = [];
    $dadosLogin    = [
      'id'       => (int) $obUsuario->id,
      'idPessoa' => (int) $obUsuario->idPessoa,
      'email'    => (string) $obUsuario->email
    ];
    
    // BUSCA OS DADOS DA PESSOA
    $obEntityPessoa = (new PessoaAction)->getIdTipoPessoa((int) $obUsuario->idPessoa);
    if(!$obEntityPessoa->getSuccess()) {
      throw new \Exception('Não foi possível realizar o login do usuário. Entre em contado com nosso suporte.', 500);
    }

    // DADOS DE CONTATO
    $obEntityTelefone = (new PessoaTelefoneAction)->getTelefoneContatoPorIdPessoa($obUsuario->idPessoa);

    // BUSCA OS DADOS PESSOAIS DO USUÁRIO
    $tipoPessoa = ($obEntityPessoa->getData() instanceof PessoaFisicaDTO) ? 'fisica': 'juridica';
    switch($tipoPessoa) {
      case 'fisica':
        $obPessoaFisica = (new PessoaFisicaAction)->getPessoaFisicaPorIdPessoa($obUsuario->idPessoa)->getData();
        $dadosPessoais  = [
          'id'        => $obPessoaFisica->id,
          'cpf'       => $obPessoaFisica->cpf,
          'nome'      => $obPessoaFisica->nome,
          'sobrenome' => $obPessoaFisica->sobrenome,
        ];
        break;
      
      case 'juridica':
        $obPessoaFisica = (new PessoaJuridicaAction)->getPessoaJuridicaPorIdPessoa($obUsuario->idPessoa)->getData();
        $dadosPessoais  = [
          'id'           => $obPessoaFisica->id,
          'cnpj'         => $obPessoaFisica->cnpj,
          'razaoSocial'  => $obPessoaFisica->razaoSocial,
          'nomeFantasia' => $obPessoaFisica->nomeFantasia,
        ];
        break;
    }

    // SALVA OS DADOS NA SESSÃO
    $dadosPessoais['tipoPessoa'] = $tipoPessoa;
    $dadosPessoais['telefone']   = $obEntityTelefone->getSuccess() ? $obEntityTelefone->getData()->telefoneContato: '';
    $this->obSession->set(['login'], $dadosLogin);
    $this->obSession->set(['dadosPessoais'], $dadosPessoais);
  }

  /**
   * Método responsável por remover a sessão do usuário
   * @return bool
   */
  public function removerSessaoUsuario(): bool {
    return $this->obSession->remove();
  }
}