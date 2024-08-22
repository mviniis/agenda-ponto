<div class="cabecalho">
  <div class="cabecalho_conteudo">
    <a href="{{ $URL_APP }}" class="cabecalho_conteudo_sair"><strong>Sair</strong></a>
    <div class="cabecalho_pesquisa">
      <img src="{{ $URL_IMG }}/geral/pesquisa.png" style="width: 30px; height: 30px;" alt="AgendaPonto Logo" class="w">
      <textarea rows="1" cols="35" class="cabecalho_conteudo_textarea"></textarea>
    </div>
    <div class="cabecalho_conteudo_perfil">
      <div class="cabecalho_conteudo_perfil_escritos">
        <h3 class="cabecalho_conteudo_perfil_texto">Olá</h3>
        <h4 class="cabecalho_conteudo_perfil_nomeusuario">Gabriel</h4>
      </div>
      <a href="{{ $URL_APP }}/editar-perfil" class="conteudo_cadastrartarefa" data-placement="top" title="Editar perfil">
        <img src="{{ $URL_IMG }}/geral/user.png" style="width: 60px; height: 60px;" alt="AgendaPonto Logo" class="w">
      </a>
    </div>
  </div>
</div>

<a href="{{ $URL_APP }}/cadastrar-tarefa" class="conteudo_cadastrartarefa position-fixed bottom-0 end-0 p-4" data-placement="top" title="Cadastrar tarefa">
  <img src="{{ $URL_IMG }}/geral/icone_cadastrar_tarefa.png" style="width: 60px; height: 60px;" alt="Cadastrar Tarefa Icone" class="w">
</a>

<!-- Lista de tarefas -->
<table class="container my-5 conteudo_tabela">
  <thead><tr><td class="conteudo_containertarefa_titulo_media" colspan="4">Lista de tarefas</td></tr></thead>
  <thead class="conteudo_tabela_cabecalho">
    <tr>
      <td class="conteudo_tabela_titulo">Nome</td>
      <td class="conteudo_tabela_titulo">Responsável</td>
      <td class="conteudo_tabela_titulo">Prioridade</td>
      <td class="conteudo_tabela_titulo">Ações</td>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < 5; $i++)
      <tr class="conteudo_tabela_linha">
        <td class="conteudo_tabela_celula">Tarefa {{ $i + 1 }}</td>
        <td class="conteudo_tabela_celula">teste{{ $i + 1 }}@teste.com.br</td>
        <td class="conteudo_tabela_celula">Normal</td>
        <td class="conteudo_tabela_celula">
          <a href="{{ $URL_APP }}/editar-tarefa/{{ $i + 1 }}" class="conteudo_containertarefa_linha_acoes_botoes">Editar</a>
          <a href="#" class="conteudo_containertarefa_linha_acoes_botoes">Remover</a>
          <a href="#" class="btn btn-dark">Concluir</a>
        </td>
      </tr>
    @endfor
  </tbody>
</table>

<!-- 
<div class="container my-5 conteudo_containertarefa">
  <div class="conteudo_containertarefa_linha_cabecalho">
    <h6>Nome</h6>
    <h6>Responsável</h6>
    <h6>Prioridade</h6>
    <div class="conteudo_containertarefa_cabecalho_acoes">
      <h6>Ações</h6>
    </div>
  </div>
  <div>
    <h3 class="conteudo_containertarefa_titulo_media">Lista de tarefas</h3>
  </div>

  @for ($i = 0; $i < 10; $i++)
    <div class="conteudo_containertarefa_linha">
      <span>Tarefa {{ $i + 1 }}</span>
    </div>
  @endfor
</div>
-->
</div>