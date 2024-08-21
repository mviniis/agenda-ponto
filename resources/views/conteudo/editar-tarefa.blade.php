<!--<h1>Editar uma tarefa</h1>

<a href="{{ $URL_APP }}/listagem-tarefas">Voltar</a>

<form action="{{ $URL_APP }}/{{ $uriFormulario }}" method="post">
  @csrf
  <input type="hidden" name="idTarefa" id="idTarefa" value="{{ $idTarefa }}">

  <div>
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" value="{{$tarefa->nome}}">
  </div>

  <label for="prioridades">Prioridade</label>
  <div id="prioridades">
    <div>
      @if($tarefa->prioridade == 'baixa')
        <input type="radio" id="baixa" name="prioridade" value="3" checked>
      @else
        <input type="radio" id="baixa" name="prioridade" value="3">
      @endif
      <label for="baixa">Baixa</label><br>
    </div>
    <div>
      @if($tarefa->prioridade == 'baixa')
        <input type="radio" id="media" name="prioridade" value="2" checked>
      @else
        <input type="radio" id="media" name="prioridade" value="2">
      @endif
      <label for="media">Média</label><br>
    </div>
    <div>
      @if($tarefa->prioridade == 'alta')
        <input type="radio" id="alta" name="prioridade" value="1" checked>
      @else
        <input type="radio" id="alta" name="prioridade" value="1">
      @endif
      <label for="alta">Alta</label>
    </div>
  </div>

  <label for="descricao">Descrição</label>
  <div>
    <textarea name="descricao" id="descricao">{{$tarefa->descricao}}</textarea>
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