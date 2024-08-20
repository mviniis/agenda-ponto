<?php

namespace App\Models\Packages\App\Usuario\Actions;

use \App\Models\DTOs\UsuarioDTO;
use \Mviniis\ConnectionDatabase\DB\{DBExecute, DBEntity};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLJoin, SQLFields, SQLWhereGroup, SQLWhere};

use function Psy\debug;

/**
 * class UsuarioAction
 * 
 * Classe responsável por centralizar os métodos de manipulação dos dados da tabela 'usuario'
 * 
 * @author Matheus Vinicius
 */
class UsuarioAction extends DBExecute {
  protected ?string $table     = 'usuario';
  protected ?string $modelData = UsuarioDTO::class;

  /**
   * Método responsável por buscar os dados de um usuário por e-mail e senha de acesso
   * @param  string       $email       E-mail do usuário que está efetuando login
   * @param  string       $senha       Senha do usuário
   * @return DBEntity
   */
  public function getUsuarioPorCredenciaisLogin(
    string $email, string $senha
  ) {
    // CONDIÇÕES DAS CREDENCIAIS
    $condicoes = new SQLWhereGroup('AND', [
      new SQLWhere('usuario.senha', '=', $senha),
      new SQLWhere('pessoa.email', '=', $email),
    ]);

    // MONTA O JOIN COM A TABELA PESSOA
    $joins   = [];
    $joins[] = new SQLJoin('pessoa', condicoes: new SQLWhere('pessoa.id', '=', 'usuario.id_pessoa', true));

    // CAMPOS QUE SERÃO RETORNADOS
    $campos = [
      new SQLFields('*', 'usuario'),
      new SQLFields('email', 'pessoa')
    ];

    return $this->select($condicoes, $joins, $campos)->fetchObject();
  }
}