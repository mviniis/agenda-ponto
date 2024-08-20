<div class="container my-5">
  <div class="conteudo_cabecalho_cabecalho">
    <div class="conteudo_cabecalho">
      <h1><strong>Criar tarefa</strong></h1>
    </div>
    <a href="{{ $URL_APP }}/listagem-tarefas" data-placement="top" title="Voltar"><img src="{{ $URL_IMG }}/geral/fechar.png" style="width: 40px; height: 40px;" alt="Fechar Icone" class="w"></a>
  </div>

  <form action="{{ $URL_APP }}/{{ $uriFormulario }}" method="post">
    @csrf

    <div class="conteudo_form_container">
      <p>Nome da tarefa</p>
      <input type="text" name="nome" id="nome" title="nome" class="conteudo_form_campo" placeholder="Nome da tarefa" autocomplete="off" required>
    </div>

    <div class="conteudo_form_container">
      <p>Prioridade</p>
      <input type="radio" class="btn-check" name="prioridade" id="baixa" value="3" autocomplete="off">
      <label class="btn check_baixa" for="baixa">Baixa</label>

      <input type="radio" class="btn-check" name="prioridade" id="media" value="2"autocomplete="off">
      <label class="btn check_media" for="media">Média</label>

      <input type="radio" class="btn-check" name="prioridade" id="alta" value="1" autocomplete="off">
      <label class="btn check_alta" for="alta">Alta</label>
    </div>

    <div class="conteudo_form_container">
      <p>Descrição</p>
      <textarea placeholder="Escreva aqui..." rows="5" cols="131" name="descricao"></textarea>
    </div>

    <div class="conteudo_form_container btn_enviar_container">
      <button type="submit" class="btn_enviar">CRIAR</button>
    </div>
  </form>
</div>