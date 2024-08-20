@isset($usuarioLogado)

<div class="cabecalho">
  <div class="cabecalho_conteudo">
    <a class="cabecalho_conteudo_sair" data-action-logout><strong>Sair</strong></a>
    
    <div class="cabecalho_conteudo_perfil">
      <div class="cabecalho_conteudo_perfil_escritos">
        <h3 class="cabecalho_conteudo_perfil_texto">Olá</h3>
        <h4 class="cabecalho_conteudo_perfil_nomeusuario">
          @if ($usuarioLogado->tipoPessoa === 'fisica')
            {{ $usuarioLogado->nome }}
          @else
            {{ $usuarioLogado->razaoSocial }}
          @endif
        </h4>
      </div>
      <a href="{{ $URL_APP }}/editar-perfil" class="conteudo_cadastrartarefa" data-placement="top" title="Editar perfil">
        <img src="{{ $URL_IMG }}/geral/user.png" style="width: 60px; height: 60px;" alt="AgendaPonto Logo" class="w">
      </a>
    </div>
  </div>
</div>

@endisset