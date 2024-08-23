<?php

namespace App\Models\Packages\App\Usuario\Actions;

use \App\Models\DTOs\UsuarioDTO;
use \Mviniis\ConnectionDatabase\DB\{DBExecute, DBEntity};
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLJoin, SQLFields, SQLSet, SQLSetItem, SQLValues, SQLValuesGroup, SQLWhereGroup, SQLWhere};

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

  /**
   * Método responsável por realizar a atualização da senha pelo ID da pessoa que o usuário representa
   * @param  int          $idPessoa        ID da pessoa
   * @param  string       $novaSenha       Nova senha do usuário
   * @return bool
   */
  public function atualizarSenhaPorIdPessoa(int $idPessoa, string $novaSenha): bool {
    if(!is_numeric($idPessoa) || $idPessoa <= 0 || !strlen($novaSenha)) return false;

    $condicao = new SQLWhere('id_pessoa', '=', $idPessoa);
    $set      = new SQLSet([
      new SQLSetItem('senha', $novaSenha)
    ]);

    return $this->update($set, $condicao)->rowCount() > 0;
  }

  /**
   * Método responsável por cadastrar um usuário
   * @param  UsuarioDTO       $obUsuarioDTO       Dados do usuário a ser adicionado
   * @return bool
   */
  public function salvar(UsuarioDTO $obUsuarioDTO): bool {
    $fields = [new SQLFields('id_pessoa'), new SQLFields('senha')];
    $values = new SQLValues([
      new SQLValuesGroup([$obUsuarioDTO->idPessoa, $obUsuarioDTO->senha])
    ]);

    $idUsuario = $this->insert($fields,$values)->getLastInsertId();
    return is_numeric($idUsuario);
  }
}