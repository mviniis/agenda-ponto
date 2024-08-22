<?php

namespace App\Models\Packages\App\Tarefa\Validates;

use App\Models\DTOs\TarefaDTO;
use App\Models\DTOs\UsuarioDTO;
use App\Models\Packages\App\Tarefa\Actions\TarefaAction;
use App\Models\Packages\App\TarefaHistorico\Actions\TarefaHistoricoAction;
use App\Models\Packages\App\TarefaUsuario\Actions\TarefaUsuarioAction;
use App\Models\Packages\App\Usuario\Actions\UsuarioAction;
use App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \Exception;
use \App\Models\Packages\Sistema\Senha\Gerenciador;

use function Psy\debug;

/**
 * class UsuarioLogin
 * 
 * Classe responsável por realizar a validação do login de um usuário
 * 
 * @author Matheus Vinicius
 */
class Tarefa {
  /**
   * Guarda os dados das tarefas
   * @var array
   */
  private $obTarefas;

  /**
   * Objeto da classe TarefaAction
   * @var TarefaAction
   */
  private $obTarefaAction;

  /**
   * Objeto da classe TarefaUsuarioAction
   * @var TarefaUsuarioAction
   */
  private $obTarefaUsuarioAction;

  /**
   * Objeto da classe TarefaUsuarioAction
   * @var TarefaHistoricoAction
   */
  private $obTarefaHistoricoAction;

  /**
   * Objeto da classe UsuarioSessao
   * @var UsuarioSessao
   */
  private $usuario;

  public function __construct() {
    $this->obTarefaAction          = new TarefaAction();
    $this->obTarefaUsuarioAction   = new TarefaUsuarioAction();
    $this->usuario                 = new UsuarioSessao;
    $this->obTarefaHistoricoAction = new TarefaHistoricoAction();
  }
  

  /**
   * Método responsável por retornar os dados de tarefas vinculadas ao usuário
   * @param  int $pagina - Página acessada
   * @return array
   */
  public function getTarefas($pagina): array {

    $this->buscarTarefasUsuario($pagina)->buscaProprietarioTarefa()->buscaPermissaoUsuarioTarefa();

    if(!is_array($this->obTarefas)) {
      throw new Exception('Não existe nenhuma tarefa válida.', 406);
    }

    return $this->obTarefas;
  }

  /**
   * Método responsável por retornar o conteúdo de uma tarefa específica
   * @param  int $idTarefa - ID da tarefa
   * @return array
   */
  public function getConteudoTarefa($idTarefa): array {

    $obEntity = $this->obTarefaAction->getTarefaPorId($idTarefa);

    $this->obTarefas = $this->toArray($obEntity->getData(), 'unitaria');

    return $this->obTarefas;
  }


  /**
   * Método responsável por buscar todas as tarefas relacionadas a um usuário
   * @return object
   */
  private function buscarTarefasUsuario($pagina) {
    $idUsuario = $this->usuario->getIdUsuarioLogado();
    $obEntity = $this->obTarefaAction->getTarefasPorUsuario($idUsuario, $pagina);

    // VERIFICA SE A CONSULTA FOI BEM SUCEDIDA
    if(!$obEntity->getSuccess()) {
      throw new Exception(
        'Não foi encontrada nenhuma tarefa para esse usuário.', 
        404
      );
    }

    // SALVA AS TAREFAS
    $this->obTarefas = $this->toArray($obEntity->getAllData(),'multipla');

    return $this;
  }

  /**
   * Método responsável por identificar a permissão que o usuário possui para cada tarefa a qual ele está relacionado
   * @return object
   */
  public function buscaPermissaoUsuarioTarefa(){

    $newArrTarefas = $this->obTarefas;
    $idUsuario = $this->usuario->getIdUsuarioLogado();

    if(!empty($this->obTarefas) && !is_null($this->obTarefas)){
      $newArrTarefas = [];

      foreach($this->obTarefas as $tarefa){
  
        
        $obRetorno =  $this->obTarefaUsuarioAction->getPermissaoTarefa($tarefa['id'], $idUsuario);
        $obRetorno = $obRetorno->getData();
        
        $tarefa['permissao'] = [
          'nome'       => $obRetorno->nome,
          'visualizar' => $obRetorno->visualizar,
          'editar'     => $obRetorno->editar,
          'remover'    => $obRetorno->remover
        ];
  
        $newArrTarefas[] = $tarefa;
        
      }
    }

    $this->obTarefas = $newArrTarefas;

    return $this;

  }

  /**
   * Método responsável por identificar o proprtetário de uma tarefa
   * @return object
   */
  public function buscaProprietarioTarefa(){

    $newArrTarefas = $this->obTarefas;

    if(!empty($this->obTarefas) && !is_null($this->obTarefas)){

      $newArrTarefas = [];
      foreach($this->obTarefas as $tarefa){
        $obRetorno =  $this->obTarefaUsuarioAction->getProprietarioTarefa($tarefa['id'], 1);
        $obRetorno = $obRetorno->getData();
  
        $nome = empty($obRetorno->nome_fantasia) ? $obRetorno->nome . ' ' .  $obRetorno->sobrenome : $obRetorno->nome_fantasia;
        $email = $obRetorno->email;
  
        
        $tarefa['responsavel'] = (!empty($nome) && !is_null($nome) && !empty($email) && !is_null($email)) ? 
                                      $nome . ' (' . $email . ')' :
                                      '';
  
        $newArrTarefas[] = $tarefa;
        
      }
    }

    $this->obTarefas = $newArrTarefas;

    return $this;
  }

  /**
   * Método responsável por cadastrar uma tarefa
   * @param  array $dadosCadastro - Dados de cadastro de uma tarefa
   * @return bool
   */
  public function cadastrarTarefa($dadosCadastro): bool{
    $idUsuario = $this->usuario->getIdUsuarioLogado();
    $idTarefa = $this->obTarefaAction->cadastrarTarefa($dadosCadastro);
    $resultado = $this->obTarefaUsuarioAction->cadastrarMapeamentoTarefa($idUsuario,$idTarefa);
    if($resultado) $this->obTarefaHistoricoAction->registrarCriacao($idTarefa, $idUsuario);
    return $resultado;
  }

  /**
   * Método responsável por atualizar os dados de uma tarefa
   * @param  array $dadosAtualizacao - Novos dados da tarefa para atualização
   * @return bool
   */
  public function atualizaTarefa($dadosAtualizacao): bool{
    //OBTÉM OS DADOS ANTIGOS DA TAREFA
    $this->getConteudoTarefa($dadosAtualizacao['idTarefa']);
    $dadosAntigos = $this->obTarefas;

    $idUsuario = $this->usuario->getIdUsuarioLogado();
    $resultado = $this->obTarefaAction->atualizaTarefa($dadosAtualizacao);

    //OBTÉM OS DADOS ATUALIZADOS DA TAREFA
    $this->getConteudoTarefa($dadosAtualizacao['idTarefa']);
    $dadosAtualizados = $this->obTarefas;

    if($resultado) $this->obTarefaHistoricoAction->registrarAlteracao($dadosAntigos, $dadosAtualizados, $dadosAtualizacao['idTarefa'],$idUsuario);
    return $resultado;
  }

  /**
   * Método responsável por excluir uma tarefa
   * @param  int $idTarefa - ID da tarefa
   * @return void
   */
  public function excluirTarefa($idTarefa){
    $idUsuario = $this->usuario->getIdUsuarioLogado();
    $resultado = $this->obTarefaUsuarioAction->excluirMapeamentoTarefa($idTarefa);
    if($resultado) $this->obTarefaHistoricoAction->registrarExclusao($idTarefa, $idUsuario);
    return $resultado;
  }

  /**
   * Método responsável por excluir uma tarefa
   * @param  int $idTarefa - ID da tarefa
   * @return void
   */
  public function concluirTarefa($idTarefa){
    //OBTÉM OS DADOS ANTIGOS DA TAREFA
    $this->getConteudoTarefa($idTarefa);
    $dadosAntigos = $this->obTarefas;

    $idUsuario = $this->usuario->getIdUsuarioLogado();
    $resultado = $this->obTarefaAction->concluirTarefa($idTarefa);

    //OBTÉM OS DADOS ATUALIZADOS DA TAREFA
    $this->getConteudoTarefa($idTarefa);
    $dadosAtualizados = $this->obTarefas;

    if($resultado) $this->obTarefaHistoricoAction->registrarAlteracao($dadosAntigos, $dadosAtualizados, $idTarefa,$idUsuario);
    return $resultado;
  }


  /**
   * Método responsável por conveter um objeto de banco em um array
   * @return array 
   */
  public function toArray($obTarefas, $tipo): array {

    $arrTarefas = [];

    if($tipo == 'multipla'){
      foreach($obTarefas as $obTarefa) {
        $arrTarefas[] = [
            'id' => $obTarefa->id,
            'nome' => $obTarefa->nome,
            'descricao' => $obTarefa->descricao,
            'idPrioridade' => $obTarefa->idPrioridade,
            'concluido' => $obTarefa->concluido,
            'prioridade' => $obTarefa->prioridade
        ];
      }
    }
    else {
      $arrTarefas = [
        'id' => $obTarefas->id,
        'nome' => $obTarefas->nome,
        'descricao' => $obTarefas->descricao,
        'idPrioridade' => $obTarefas->idPrioridade,
        'concluido' => $obTarefas->concluido,
        'prioridade' => $obTarefas->prioridade
      ];
    }

    
    return $arrTarefas;
  }

}