<?php

namespace App\Models\Packages\App\RecuperacaoSenha\Sessao;

use \App\Models\DTOs\RecuperarSenhaDTO;
use \App\Models\Packages\Sistema\Sessao\SessionManager;

/**
 * class RecuperarSenhaSessao
 * 
 * Classe responsável por realizar a manipulação dos dados da recuperação de senha na sessão
 * 
 * @author Matheus Vinicius
 */
class RecuperarSenhaSessao {
  /**
   * Guarda o objeto de manipução da sessão da recuperação de senha
   * @var SessionManager
   */
  private SessionManager $obSession;

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->obSession = (new SessionManager(['recuperacaoSenha']));
  }

  public function getDadosSalvos(): array {
    return $this->obSession->get() ?? [];
  }

  /**
   * Método responsável por salvar os dados da recuperação de senha na sessão
   * @param  RecuperarSenhaDTO      $obRecupearacao      Dados da recuperação de senha
   * @return void
   */
  public function salvarCodigoConfirmacaoSessao(RecuperarSenhaDTO $obRecupearacao): void {
    // REMOVE A SESSÃO CASO JÁ EXISTA
    $this->obSession->remove();

    // SALVA OS NOVOS DADOS
    $this->obSession->set(['codigo'], $obRecupearacao->codigo);
    $this->obSession->set(['dataExpiracao'], $obRecupearacao->dataHoraExpiracao);
  }
}