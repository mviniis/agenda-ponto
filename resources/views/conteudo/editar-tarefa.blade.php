<h1>Editar uma tarefa</h1>

<a href="{{ $URL_APP }}/listagem-tarefas">Voltar</a>

<form action="{{ $URL_APP }}/{{ $uriFormulario }}" method="post">
  @csrf
  <input type="hidden" name="idTarefa" id="idTarefa" value="{{ $idTarefa }}">

  <div>
    <label for="email">Tĩtulo</label>
    <input type="email" name="email" id="email">
  </div>

  <div>
    <label for="nome">Data de vencimento</label>
    <input type="date" name="nome" id="nome">
  </div>

  <label for="senha">Prioridade</label>
  <div id="prioridades">
    <div>
      <input type="radio" id="baixa" name="prioridade" value="baixa">
      <label for="baixa">Baixa</label><br>
    </div>
    <div>
      <input type="radio" id="media" name="prioridade" value="media">
      <label for="media">Média</label><br>
    </div>
    <div>
      <input type="radio" id="alta" name="prioridade" value="alta">
      <label for="alta">Alta</label>
    </div>
  </div>

  <label for="descricao">Descrição</label>
  <div>
    <textarea name="descricao" id="descricao"></textarea>
  </div>

  <button type="submit">Enviar</button>
</form>