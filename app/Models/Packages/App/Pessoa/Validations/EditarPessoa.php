<?php

namespace App\Models\Packages\App\Pessoa\Validations;

use \Exception;
use \App\Models\Packages\App\Pessoa\Actions\PessoaAction;
use \App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;

/**
 * class Pessoa
 * 
 * Classe responsável por validar os dados de uma pessoa
 * 
 * @author Matheus Vinicius
 */
class EditarPessoa {
  /**
   * Define se a pessoa sendo validada é do tipo pessoa física ou jurídica
   * @var string
   */
  private bool $tipoPessoaFisica = false;

  /**
   * Define o ID do usuario logado
   * @var int
   */
  private int $idUsuario = 0;

  /**
   * Define o ID da pessoa logada
   * @var int
   */
  private int $idPessoa = 0;

  /**
   * Construtor da classe
   * @param string      $email             Novo e-mail do usuário
   * @param string      $nome              Nome ou Razão Social
   * @param string      $sobrenome         Sobrenome ou Nome Fantasia da pessoa
   * @param string      $cpfCnpj           CPF/CNPJ da pessoa
   * @param bool        $tipoPessoa        
   */
  public function __construct(
    private string $email,
    private string $nome,
    private string $sobrenome,
    private ?string $cpfCnpj = null
  ) {}

  /**
   * Método responsável por definir o tipo da pessoa do usuário logado
   * @return self
   */
  public function definirTipoPessoaUsuarioLogado(): self {
    $this->tipoPessoaFisica = (new UsuarioSessao)->getTipoPessoaUsuarioLogado() == 'fisica';
    return $this;
  }

  /**
   * Método responsável por definir o ID da pessoa e do usuário logado
   * @return self
   */
  public function definirIdsUsuarioLogado(): self {
    $this->idPessoa  = (new UsuarioSessao)->getDadosLogin()['idPessoa'];
    $this->idUsuario = (new UsuarioSessao)->getIdUsuarioLogado();
    return $this;
  }

  /**
   * Método responsável por retornar se a pessoa sendo validada é do tipo pessoa física
   * @return bool
   */
  public function getTipoPessoaFisica(): bool {
    return $this->tipoPessoaFisica;
  }

  /**
   * Método responsável por retornar o ID da pessoa sendo validada
   * @return int
   */
  public function getIdPessoa(): int {
    return $this->idPessoa;
  }

  /**
   * Método responsável por retornar o ID do usuário sendo validado
   * @return int
   */
  public function getIdUsuario(): int {
    return $this->idUsuario;
  }

  /**
   * Método responsável por realizar a validação do e-mail do usuário informado
   * @return self
   */
  public function validarEmailUsuarioLogado(): self {
    // REMOVE OS ESPAÇOS EM BRANCO
    $email = str_replace(' ', '', $this->email);

    // VERIFICA SE O E-MAIL É VÁLIDO
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("O e-mail informado é inválido", 400);
    }

    // VERIFICA SE O E-MAIL É IGUAL AO DADOS DO USUÁRIO LOGADO
    $email = (new UsuarioSessao)->getDadosLogin()['email'];
    if($this->email == $email) return $this;

    // VERIFICA SE JÁ EXISTE UM E-MAIL CADASTRADO
    if((new PessoaAction)->verificarDuplicidadeEmail($this->email)) {
      throw new Exception('O e-mail informado é inválido.', 400);
    }

    return $this;
  }

  /**
   * Método responsável por validar o nome de uma pessoa vinculada a um usuário
   * @return self
   */
  public function validarNomes(): self {
    // VERIFICA SE O NOME OU O SOBRENOME É UM TEXTO PREENCHIDO
    $nomePossuiValores = (bool) strlen(str_replace(' ', '', $this->nome));
    if(!$nomePossuiValores) {
      $mensagemPessoaFisica   = 'O campo "nome" é obrigatório!';
      $mensagemPessoaJuridica = 'O campo "Razão Social" é obrigatório!';
      throw new Exception(($this->tipoPessoaFisica ? $mensagemPessoaFisica: $mensagemPessoaJuridica), 406);
    }

    // VERIFICA SE O NOME OU O SOBRENOME POSSUI ALGUM CARACTER INVÁLIDO
    $regex                              = '/[^a-zA-Z\s]/';
    $nomePossuiCaracteresInvalidos      = (bool) preg_match($regex, $this->nome);
    $sobrenomePossuiCaracteresInvalidos = (bool) preg_match($regex, $this->sobrenome);
    if($nomePossuiCaracteresInvalidos || $sobrenomePossuiCaracteresInvalidos) {
      $mensagemPessoaFisica   = 'O nome ou sobrenome informado é inválido!';
      $mensagemPessoaJuridica = 'A razão social ou o nome fantasia informado é inválido!';
      throw new Exception(($this->tipoPessoaFisica ? $mensagemPessoaFisica: $mensagemPessoaJuridica), 406);
    }

    return $this;
  }
}