<section class="conteudo">
  <div class="cabecalho">
    <a href="{{ $URL_APP }}/listagem-tarefas" class="btn btn_formatado">Voltar</a>
  </div>
  <div class="principal">

    <form action="{{ $URL_APP }}/editar-perfil" method="post" class="container_form">
      @csrf

      <div class="container_icone">
        <img src="{{ $URL_IMG }}/geral/user_preto.png" style="width: 120px; height: auto;" alt="AgendaPonto Logo" class="w">
        <input type="file" name="user_foto" class="btn btn_alterar_foto">
        <label for="user_foto" class="w">Alterar foto</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="nome" id="nome" class="form-control input_formatacao" placeholder="Nome">
        <label for="nome" class="w">Nome</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="sobrenome" id="sobrenome" class="form-control input_formatacao" placeholder="Sobrenome">
        <label for="sobrenome" class="w">Sobrenome</label>
      </div>
      
      <div class="form-floating mb-3">
        <input type="email" name="email" id="email" class="form-control input_formatacao" placeholder="E-mail">
        <label for="email" class="w">E-mail</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="telefone" id="telefone" class="form-control input_formatacao" placeholder="Telefone">
        <label for="telefone" class="w">Telefone</label>
      </div>

      <div class="container_botao">
        <button type="submit" class="btn btn_enviar">ENVIAR</button>
      </div>
    </form>
  </div>
  <div class="rodape"></div>
</section>