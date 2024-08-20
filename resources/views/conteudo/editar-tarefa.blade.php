<!--<h1>Editar uma tarefa</h1>

<a href="{{ $URL_APP }}/listagem-tarefas">Voltar</a>

<form action="{{ $URL_APP }}/{{ $uriFormulario }}" method="post">
  @csrf
  <input type="hidden" name="idTarefa" id="idTarefa" value="{{ $idTarefa }}">

  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email">
  </div>

  <div>
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome">
  </div>

  <div>
    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha">
  </div>

  <div>
    <label for="confirmarSenha">Confirmar senha</label>
    <input type="password" name="confirmarSenha" id="confirmarSenha">
  </div>

  <button type="submit">Enviar</button>
</form>
-->
<div class="cabecalho">
  <div class="cabecalho_conteudo">
    <a href="{{ $URL_APP }}/listagem-tarefas"" class="cabecalho_conteudo_sair"><strong>Sair</strong></a>
  </div>
</div>


<div class="container py-5 conteudo_form">
  <div class="conteudo_cabecalho_cabecalho">
    <div class="conteudo_cabecalho">
      <h1><strong>Editar tarefa</strong></h1>
    </div>
    <a href="{{ $URL_APP }}/listagem-tarefas" data-placement="top" title="Voltar"><img src="{{ $URL_IMG }}/geral/fechar.png" class="conteudo_sair" alt="Fechar Icone" class="w"></a>
  </div>

  <form action="{{ $URL_APP }}/cadastrarAtualizarTarefa" method="post">
    @csrf

    <div class="conteudo_form_container">
      <p>Nome da tarefa</p>
      <input type="text" name="nomeTarefa" id="nomeTarefa" title="nomeTarefa" class="conteudo_form_campo" placeholder="Nome da tarefa" autocomplete="off" required>
    </div>

    <div class="conteudo_form_container">
      <p>Prioridade</p>
      <input type="radio" class="btn-check" name="definirPrioridade" id="baixa" autocomplete="off">
      <label class="btn check_baixa" for="baixa">Baixa</label>

      <input type="radio" class="btn-check" name="definirPrioridade" id="media" autocomplete="off">
      <label class="btn check_media" for="media">Média</label>

      <input type="radio" class="btn-check" name="definirPrioridade" id="alta" autocomplete="off">
      <label class="btn check_alta" for="alta">Alta</label>
    </div>

    <div class="conteudo_form_container">
      <p>Descrição</p>
      <input type="text" class="conteudo_form_campo_descricao" placeholder="Escreva aqui..." name="descricao"></input>
    </div>

    <div class="conteudo_form_container btn_enviar_container">
      <button type="submit" class="btn_enviar">SALVAR</button>
    </div>
  </form>
</div>
<div class="conteudo_footer"></div>