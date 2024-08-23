<section class="conteudo">
  <div class="cabecalho">
    <a href="{{ $URL_APP }}/listagem-tarefas" class="btn btn_formatado">Voltar</a>
  </div>

  <div class="principal py-4">
    <div class="p-1 alert d-none" role="alert" data-alerta-login></div>

    <form action="{{ $URL_APP }}/editar-perfil" method="post" class="container_form" id="editarPerfil">
      <div class="container_icone">
        <img src="{{ $URL_IMG }}/geral/user_preto.png" style="width: 120px; height: auto;" alt="AgendaPonto Logo" class="w">
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="nome" id="nome" 
          class="form-control input_formatacao" placeholder="Nome" value="{{ $dadosUsuario->nome }}"
        >
        <label for="nome" class="w">{{ $dadosUsuario->labelNome }}</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="sobrenome" id="sobrenome" 
          class="form-control input_formatacao" placeholder="Sobrenome"
          value="{{ $dadosUsuario->sobrenome }}"
        >
        <label for="sobrenome" class="w">{{ $dadosUsuario->labelSobrenome }}</label>
      </div>
      
      <div class="form-floating mb-3">
        <input type="email" name="email" id="email" 
          class="form-control input_formatacao" placeholder="E-mail"
          value="{{ $dadosUsuario->email }}"
        >
        <label for="email" class="w">E-mail</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="telefone" id="telefone" 
          class="form-control input_formatacao" placeholder="Telefone"
          value="{{ $dadosUsuario->telefone }}"
        >
        <label for="telefone" class="w">Telefone de contato</label>
      </div>

      <div class="container_botao">
        <button type="submit" class="btn btn_enviar">
          ENVIAR

          <div class="spinner-border d-none" role="status" data-spinner-editar-usuario>
              <span class="visually-hidden">Carregando...</span>
          </div>
        </button>
      </div>
    </form>
  </div>
  <div class="rodape"></div>
</section>