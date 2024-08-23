<?php

namespace App\Models\Packages\App\Pessoa\Validations;

use \Exception;
use \Mviniis\ConnectionDatabase\DTO\DTO;
use \App\Models\DTOs\{PessoaDTO, PessoaFisicaDTO, PessoaJuridicaDTO};
use \App\Models\Packages\App\Pessoa\Actions\{PessoaAction, PessoaFisicaAction, PessoaJuridicaAction};

/**
 * class CadastrarPessoa
 * 
 * Classe responsável por realizar as validações de um cadastro de pessoa
 * 
 * @author Matheus Vinicius
 */
class CadastrarPessoa {
  /**
   * Define o nome da pessoa
   * @var string
   */
  private ?string $nome;

  /**
   * Define o sobrenome da pessoa
   * @var string
   */
  private ?string $sobrenome;

  /**
   * Define o e-mail da pessoa
   * @var string
   */
  private ?string $email;

  /**
   * Define o docuemento da pessoa
   * @var string
   */
  private ?string $documento;

  /**
   * Define se é uma pessoa física ou jurídica
   * @var bool
   */
  private bool $pessoaFisica = true;

  /**
   * Construtor da classe
   * @param array       $request       Dados da requisição
   */
  public function __construct(array $request) {
    $this->pessoaFisica = ($request['pessoaFisica'] == 'true');
    $this->email        = $request['email'];
    $this->documento    = $request['documento'];
    $this->nome         = $request['nome'];
    $this->sobrenome    = $request['sobrenome'];
  }

  /**
   * Método responsável por retornar se a validação é de uma pessoa física ou jurídica
   * @return bool
   */
  public function isPessoaFisica(): bool {
    return $this->pessoaFisica;
  }

  /**
   * Método responsável por validar o e-mail
   * @return self
   */
  public function validarEmail(): self {
    $emailExiste    = !is_null($this->email);
    $emailValido    = filter_var($this->email, FILTER_VALIDATE_EMAIL);
    $emailDuplicado = (new PessoaAction)->verificarDuplicidadeEmail($this->email);
    if(!$emailExiste || !$emailValido || $emailDuplicado) {
      throw new Exception('O e-mail informado é inválido.', 400);
    }

    return $this;
  }

  /**
   * Método responsável por encapsular as validações do documento do usuário
   * @return self
   */
  public function validarDocumento(): self {
    if($this->pessoaFisica && !$this->validarCPF()) {
      throw new Exception('O CPF informado é inválido.');
    }

    if(!$this->pessoaFisica && !$this->validarCNPJ()) {
      throw new Exception('O CNPJ informado é inválido.');
    }
    
    $this->documento = $this->getNumeros($this->documento);
    return $this;
  }

  /**
   * Método responsável por validar o nome de uma pessoa vinculada a um usuário
   * @return self
   */
  public function validarNomes(): self {
    // VERIFICA SE O NOME OU O SOBRENOME É UM TEXTO PREENCHIDO
    $nomeCampo         = $this->pessoaFisica ? 'Nome': 'Razão Social';
    $nomePossuiValores = (bool) strlen(str_replace(' ', '', $this->nome));
    if(!$nomePossuiValores) throw new Exception("O campo '{$nomeCampo}' é obrigatório!", 406);

    // VERIFICA SE O NOME OU O SOBRENOME POSSUI ALGUM CARACTER INVÁLIDO
    $regex                              = '/[^a-zA-Z\s]/';
    $sobrenomeCampo                     = $this->pessoaFisica ? 'Sobrenome': 'Nome Fantasia';
    $nomePossuiCaracteresInvalidos      = (bool) preg_match($regex, $this->nome);
    $sobrenomePossuiCaracteresInvalidos = (bool) preg_match($regex, $this->sobrenome);
    if($nomePossuiCaracteresInvalidos || $sobrenomePossuiCaracteresInvalidos) {
      throw new Exception("O {$nomeCampo} ou {$sobrenomeCampo} são inválidos!", 406);
    }

    return $this;
  }

  /**
   * Método responsável por montar o objeto DTO de pessoa
   * @return DTO
   */
  public function getObjetoDtoPessoa(): DTO {
    $obPessoaDTO        = new PessoaDTO;
    $obPessoaDTO->email = $this->email;
    return $obPessoaDTO;
  }

  /**
   * Método responsável por retornar os dados de um objeto pelo tipo da pessoa
   * @return DTO
   */
  public function getObjetoDtoPorTipoPessoa(): DTO {
    return $this->pessoaFisica ? $this->getObjetoPessoaFisica(): $this->getObjetoPessoaJuridica();
  }

  /**
   * Método responsável por retonar um objeto DTO de pessoa física
   * @return DTO
   */
  private function getObjetoPessoaFisica(): DTO {
    $obPessoaFisica            = new PessoaFisicaDTO;
    $obPessoaFisica->nome      = $this->nome;
    $obPessoaFisica->sobrenome = $this->sobrenome;
    $obPessoaFisica->cpf       = $this->documento;
    return $obPessoaFisica;
  }

  /**
   * Método responsável por retornar um objeto DTO de pessoa jurídica
   * @return DTO
   */
  private function getObjetoPessoaJuridica(): DTO {
    $obPessoaFisica               = new PessoaJuridicaDTO();
    $obPessoaFisica->razaoSocial  = $this->nome;
    $obPessoaFisica->nomeFantasia = $this->sobrenome;
    $obPessoaFisica->cnpj         = $this->documento;
    return $obPessoaFisica;
  }

  /**
   * Método responsável por remover os caracteres que não são números
   * @param  string      $valor      Valor que será formatado
   * @return int
   */
  private function getNumeros(string $valor): int {
    return preg_replace('/[^\d]/', '', $valor);
  }

  /**
   * Método responsável por validar um CPF
   * @return bool
   */
  private function validarCPF(): bool {
    $pattern = '/^\d{3}\.\d{3}\.\d{3}-\d{2}$/';
    $valido  = (bool) preg_match($pattern, $this->documento);
    if(!$valido) return false;
    
    // VERIFICA SE O CPF INFORMADO JÁ EXISTE
    return !(new PessoaFisicaAction)->validarDuplicidadeCpf($this->getNumeros($this->documento));
  }

  /**
   * Método responsável por validar um CNPJ
   * @return bool
   */
  private function validarCNPJ(): bool {
    $pattern = '/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/';
    $valido  = (bool) preg_match($pattern, $this->documento);
    if(!$valido) return false;

    return !(new PessoaJuridicaAction)->validarDuplicidadeCnpj($this->getNumeros($this->documento));
  }
}