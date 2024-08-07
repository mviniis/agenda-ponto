<h1>Editar uma tarefa</h1>

<a href="{{ $URL_APP }}/listagem-tarefas">Voltar</a>

<form action="{{ $URL_APP }}/{{ $uriFormulario }}" method="post">
  @csrf

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