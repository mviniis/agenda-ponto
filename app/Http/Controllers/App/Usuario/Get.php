<?php

namespace App\Http\Controllers\App\Usuario;

use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};

/**
 * class Get
 * 
 * Classe responsável por controlar as requisições GET a página de edição do usuário logado
 * 
 * @author Matheus Vinicius
 */
class Get extends Base {
  public function configure(): self {
    // INSTÂNCIA DOS ARQUIVOS DE ESTILO
    $obHandlerCSS = new HandlerCss;
    $obHandlerJS  = new HandlerJs;

    // DEFINE O NOME DO ARQUIVO DE HANDLER
    $obHandlerCSS->defineHandlerFileName('handler-editar-perfil');
    $obHandlerJS->defineHandlerFileName('handler-editar-perfil');

    // CONFIGURAÇÃO DOS ARQUIVOS
    $obHandlerCSS->setFilesAndFolders([
      'geral', 'botstrap', 'editar-perfil'
    ]);
    $obHandlerJS->setFilesAndFolders([
      'geral', 'botstrap', 'editar-perfil'
    ]);

    // DEFINIÇÃO DOS OBJETOS
    $this->handlerCSS = $obHandlerCSS;
    $this->handlerJS  = $obHandlerJS;

    return $this;
  }

  /**
   * Método responsável por realizar a chamada do conteúdo da página
   * @return string
   */
  public function consultar() {
    $this->configure();

    // MONTA OS ARQUIVO DE HANDLER
    $this->atualizarHandlers();

    // ADICIONA OS DADOS DO CLIENTE LOGADO
    $obSessao            = new UsuarioSessao;
    $usuarioPessoaFisica = $obSessao->tipoUsuarioPessoaFisica();
    $dadosLogin          = (new UsuarioSessao)->getDadosLogin();
    $dadosPessoais       = (new UsuarioSessao)->getDadosPessoais();
    $this->addConteudo('dadosUsuario', [
      'email'          => $dadosLogin['email'],
      'nome'           => $usuarioPessoaFisica ? $dadosPessoais['nome']: $dadosPessoais['razaoSocial'],
      'sobrenome'      => $usuarioPessoaFisica ? $dadosPessoais['sobrenome']: $dadosPessoais['nomeFantasia'],
      'telefone'       => $dadosPessoais['telefone'],
      'labelNome'      => $usuarioPessoaFisica ? 'Nome': 'Razão social',
      'labelSobrenome' => $usuarioPessoaFisica ? 'Sobrenome': 'Nome Fantasia'
    ]);

    return $this->getConteudo('editar-perfil');
  }
}
