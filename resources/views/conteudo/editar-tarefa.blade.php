
<div class="container py-5 conteudo_form">
  <div class="conteudo_cabecalho_cabecalho">
    <div class="conteudo_cabecalho">
      <h1><strong>Editar tarefa</strong></h1>
    </div>
    <a href="{{ $URL_APP }}/listagem-tarefas" data-placement="top" title="Voltar"><img src="{{ $URL_IMG }}/geral/fechar.png" class="conteudo_sair" alt="Fechar Icone" class="w"></a>
  </div>

  <form class="editarTarefaForm" method="POST">
    @csrf

    <input type="hidden" name="idTarefa" id="idTarefa" value="{{ $idTarefa }}">

    <div class="conteudo_form_container">
      <p>Nome da tarefa</p>
      <input type="text" value="{{$tarefa->nome}}" name="nome" id="nomeTarefa" title="nomeTarefa" class="conteudo_form_campo" placeholder="Nome da tarefa" autocomplete="off" required>
    </div>

    <div class="conteudo_form_container">
      <p>Prioridade</p>
      @if($tarefa->prioridade == 'baixa')
        <input type="radio" class="btn-check" name="prioridade" id="baixa" autocomplete="off" value="3" checked>
      @else
        <input type="radio" class="btn-check" name="prioridade" id="baixa" autocomplete="off" value="3">
      @endif
      <label class="btn check_baixa" for="baixa">Baixa</label>

      @if($tarefa->prioridade == 'media')
        <input type="radio" class="btn-check" name="prioridade" id="media" autocomplete="off" value="2" checked>
      @else
        <input type="radio" class="btn-check" name="prioridade" id="media" autocomplete="off" value="2">
      @endif
      <label class="btn check_media" for="media">Média</label>
      
      @if($tarefa->prioridade == 'alta')
        <input type="radio" class="btn-check" name="prioridade" id="alta" autocomplete="off" value="1" checked>
      @else
        <input type="radio" class="btn-check" name="prioridade" id="alta" autocomplete="off" value="1">
      @endif
      <label class="btn check_alta" for="alta">Alta</label>
    </div>

    <div class="conteudo_form_container">
      <p>Descrição</p>
      <textarea id="descricao" class="conteudo_form_campo_descricao" placeholder="Escreva aqui..." name="descricao">{{$tarefa->descricao}}</textarea>
    </div>

    <div class="conteudo_form_container btn_enviar_container">
      <button type="submit" class="btn_enviar">SALVAR</button>
    </div>
  </form>
</div>
<div class="conteudo_footer"></div>