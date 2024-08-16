@isset($usuarioLogado)

<header>
  <h1>
    Bem vindo
    @if ($usuarioLogado->tipoPessoa === 'fisica')
      {{ $usuarioLogado->nome }} {{ $usuarioLogado->sobrenome }}
      @else
      {{ $usuarioLogado->razaoSocial }}
    @endif
  </h1>
</header>

@endisset