<div class="cabecalho">
  <div class="cabecalho_conteudo">
    <a href="#" class="cabecalho_conteudo_sair"><strong>Sair</strong></a>
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


<div class="container my-5">
  <div class="conteudo_cabecalho_cabecalho">
    <div class="conteudo_cabecalho">
      <h1><strong>Criar tarefa</strong></h1>
    </div>
    <a href="{{ $URL_APP }}/listagem-tarefas" data-placement="top" title="Voltar"><img src="{{ $URL_IMG }}/geral/fechar.png" style="width: 40px; height: 40px;" alt="Fechar Icone" class="w"></a>
  </div>

  <form action="{{ $URL_APP }}/cadastrarAtualizarTarefa" method="post">
    @csrf

    <div class="conteudo_form_container">
      <p>Nome da tarefa</p>
      <input type="text" name="nomeTarefa" id="nomeTarefa" title="nomeTarefa" class="conteudo_form_campo" placeholder="Nome da tarefa" autocomplete="off" required>
    </div>

    <div class="conteudo_form_container">
      <p>Data de Vencimento</p>
      <input type="date" name="dataVencimento" id="dataVencimento" min="16/08/2024" class="conteudo_form_campo" autocomplete="off" required>
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
      <textarea placeholder="Escreva aqui..." rows="5" cols="131" name="descricao"></textarea>
    </div>

    <div class="conteudo_form_container btn_enviar_container">
      <button type="submit" class="btn_enviar">CRIAR</button>
    </div>
  </form>
</div>