<?php

namespace App\Models\Packages\App\RecuperacaoSenha\Actions;

use \App\Models\DTOs\PessoaDTO;
use \App\Mail\RecuperacaoSenhaEmail;
use \Illuminate\Support\Facades\Mail;
use \App\Models\DTOs\RecuperarSenhaDTO;
use \Mviniis\ConnectionDatabase\DB\DBEntity;
use \Mviniis\ConnectionDatabase\DB\DBExecute;
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLFields, SQLValues, SQLValuesGroup, SQLWhere};

/**
 * class RecuperarSenhaAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'recuperar_senha'
 * 
 * @author Matheus Vinicius
 */
class RecuperarSenhaAction extends DBExecute {
  protected ?string $table     = 'recuperar_senha';
  protected ?string $modelData = RecuperarSenhaDTO::class;

  /**
   * Método responsável por remover os códigos de verificação de uma pessoa
   * @param  int      $idPessoa      ID da pessoa
   * @return bool
   */
  public function removerCodigosPorPessoa(int $idPessoa): bool {
    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);
    return $this->delete($condicao)->rowCount() > 0;
  }

  /**
   * Método responsável por obter os dados de um código de confirmação por ID
   * @param  int      $idCodigo      ID do código de verificação
   * @return DBEntity
   */
  public function getCodigoConfirmacaoPorId(int $idCodigo): DBEntity {
    $condicao = new SQLWhere('id', '=', $idCodigo);
    return $this->select($condicao)->fetchObject();
  }
  
  /**
   * Método responsável por salvar o banco o código de verificação
   * @param  PessoaDTO      $obPessoaDTO      Dados da pessoa
   * @param  string         $codigo           Código de verificação gerado
   * @return DBEntity
   */
  public function gerarCodigoConfirmacao(PessoaDTO $obPessoaDTO, string $codigo): DBEntity {
    // REMOVE CÓDIGOS ANTIGOS
    $this->removerCodigosPorPessoa($obPessoaDTO->id);

    $sets= new SQLValues([
      new SQLValuesGroup([
        $obPessoaDTO->id, $codigo, 
        (new \DateTime())->modify('+5 minutes')->format('Y-m-d H:i:s')
      ])
    ]);

    $fields = [
      new SQLFields('id_pessoa'),
      new SQLFields('codigo'),
      new SQLFields('data_hora_expiracao')
    ];

    $idRecuperacaoCodigo = $this->insert($fields, $sets, ignore: true)->getLastInsertId();
    return $this->getCodigoConfirmacaoPorId($idRecuperacaoCodigo);
  }

  /**
   * Método responsável por realizar o envio do e-mail com o código de confirmação
   * @param  PessoaDTO                  $obPessoaDTO          Dados da pessoa
   * @param  RecuperarSenhaDTO          $obCodigo             Dados do código de verificação
   * @return bool
   */
  public function enviarEmailCodigoConfirmacao(PessoaDTO $obPessoaDTO, RecuperarSenhaDTO $obCodigo): bool {
    $dadosEmail = [
      'appName'       => $_ENV['APP_TITLE_SITE'],
      'nome'          => $obPessoaDTO->nome,
      'email'         => $obPessoaDTO->email,
      'codigo'        => $obCodigo->codigo,
      'dataExpiracao' => (new \DateTime($obCodigo->dataHoraExpiracao))->format('H:i:s'),
    ];

    // REALIZA O ENVIO DO E-MAIL
    return !is_null(Mail::to($obPessoaDTO->email)->send(new RecuperacaoSenhaEmail($dadosEmail)));
  }
}