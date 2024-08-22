<h1>Editar uma tarefa</h1>

<a href="{{ $URL_APP }}/listagem-tarefas">Voltar</a>

<form class="editarTarefaForm" method="POST">
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
      @if($tarefa->prioridade == 'media')
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