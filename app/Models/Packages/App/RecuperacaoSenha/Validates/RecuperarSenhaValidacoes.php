<?php

namespace App\Models\Packages\App\RecuperacaoSenha\Validates;

use \DateTime;
use \Exception;
use \App\Models\Packages\Sistema\Senha\Gerenciador;
use \App\Models\Packages\App\Pessoa\Actions\PessoaAction;
use \App\Models\Packages\App\RecuperacaoSenha\Sessao\RecuperarSenhaSessao;

/**
 * class RecuperarSenhaValidacoes
 * 
 * Classe responsável por realizar as validações da recuperação de senha
 * 
 * @author Matheus Vinicius
 */
class RecuperarSenhaValidacoes {
  /**
   * Construtor da classe
   * @param string      $email               E-mail do usuário que está recuperando a senha
   * @param string      $codigo              Código enviado na recuperação de senha
   * @param string      $senha               Nova senha do usuário
   * @param string      $confirmarSenha      Confirmação da senha do usuário
   */
  public function __construct(
    private ?string $email = null,
    private ?string $codigo = null,
    private ?string $senha = null,
    private ?string $confirmarSenha = null,
  ) {}

  /**
   * Método responsável por validar se o e-mail é válido
   * @return self
   */
  public function validarEmail(): self {
    $emailInformado = !is_null($this->email);
    $emailValido    = filter_var($this->email, FILTER_VALIDATE_EMAIL);
    if(!$emailInformado || !$emailValido) {
      throw new Exception('O e-mail informado é inválido.', 400);
    }

    // VERIFICA SE O E-MAIL FOI CADASTRADO
    if(!(new PessoaAction)->verificarDuplicidadeEmail($this->email)) {
      throw new Exception('E-mail não encontrado! Considere realizar o seu cadastro.', 406);
    }

    return $this;
  }

  /**
   * Método responsável por verificar se existe a sessão de recuperação de senha
   * @return self
   */
  public function verificarExistenciaSessao(): self {
    if(empty((new RecuperarSenhaSessao)->getDadosSalvos())) {
      throw new Exception('Gere um novo código de verificação', 406);
    }

    return $this;
  }
  
  /**
   * Método responsável por validar o tempo de expiração do código de verificação
   * @return self
   */
  public function validarDataExpiracao(): self {
    $obSessao        = new RecuperarSenhaSessao;
    $dadosSessao     = $obSessao->getDadosSalvos();
    $obDataAtual     = new DateTime('now');
    $obDataExpiracao = new DateTime($dadosSessao['dataExpiracao'] ?? 'now');

    // VERIFICA SE O TEMPO FOI EXCEDIDO
    if($obDataExpiracao < $obDataAtual) {
      $obSessao->remover();
      throw new Exception('O código de verificação já expirou. Gere um novo código.', 406);
    }

    return $this;
  }

  /**
   * Método responsável por validar se o código de verificação é igual ao enviado por e-mail
   * @return self
   */
  public function validarCodigoConfirmacao(): self {
    $codigo = (new RecuperarSenhaSessao)->getDadosSalvos()['codigo'] ?? 0;
    if($codigo != $this->codigo) {
      throw new Exception('O código de verificação informado não é válido', 406);
    }

    return $this;
  }

  /**
   * Método responsável por adicionar um índice para definir que a última etapa é válida
   * @return self
   */
  public function adicionarIndiceUltimaEtapa(): self {
    (new RecuperarSenhaSessao)->adicionarInciceUltimaEtapa();
    return $this;
  }

  /**
   * Método responsável por realziar a geração de um código de verificação
   * @return string
   */
  public function gerarCodigoDeValidacao(): string {
    return rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
  }

  /**
   * Método responsável por validar as senhas
   * @return self
   */
  public function validarSenhas(): self {
    if(is_null($this->senha) || is_null($this->confirmarSenha)) {
      throw new Exception('É necessário informar as duas senhas', 406);
    }

    // VALIDAÇÃO DAS SENHAS
    if($this->senha !== $this->confirmarSenha) {
      throw new Exception('As senhas não são iguais', 400);
    }

    // VALIDAÇÃO DOS PARÂMETROS DA SENHA
    Gerenciador::validarParametrosSenha($this->senha);

    return $this;
  }

  /**
   * Método responsável por encriptografar a nova senha
   * @return string
   */
  public function getNovaSenha(): string {
    return Gerenciador::criptografarSenha($this->senha);
  }

  /**
   * Método responsável por obter o ID da pessoa que está sendo validada
   * @return int
   */
  public function getIdUsuarioAlterarSenha(): int {
    return (int) (new RecuperarSenhaSessao)->getDadosSalvos()['idPessoa'];
  }

  /**
   * Método responsável por validar qual página o usário deve acessar
   * @param  string       $parte       Tipo da validação da recuperação
   * @return void
   */
  public function validarLocal(string $parte): void {
    $dadosSessao = (new RecuperarSenhaSessao)->getDadosSalvos();
    switch($parte) {
      case 'parte1':
        if(!empty($dadosSessao) && !isset($dadosSessao['ultimaEtapa'])) $this->redirecionar('/recuperar-senha/parte2');
        if(!empty($dadosSessao) && isset($dadosSessao['ultimaEtapa'])) $this->redirecionar('/recuperar-senha/parte3');
      break;
      
      case 'parte2':
        if(empty($dadosSessao)) $this->redirecionar('/recuperar-senha');
        if(!empty($dadosSessao) && isset($dadosSessao['ultimaEtapa'])) $this->redirecionar('/recuperar-senha/parte3');
      break;
      
      case 'parte3':
        if(empty($dadosSessao)) $this->redirecionar('/recuperar-senha');
        if(!empty($dadosSessao) && !isset($dadosSessao['ultimaEtapa'])) $this->redirecionar('/recuperar-senha/parte2');
      break;
    }
  }

  /**
   * Método responsável pelo redirecionamento de páginas
   * @param  string       $local       Página que deve ser redirecionada
   * @return void
   */
  private function redirecionar(string $local) {
    header('Location: ' . $_ENV['APP_URL'] . $local);
    exit;
  }
}