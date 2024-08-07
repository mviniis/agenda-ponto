<h1>Cadastrar usuário</h1>

<form action="{{ $URL_APP }}/cadastro" method="post">
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

<a href="{{ $URL_APP }}/">Efetuar login</a>
<a href="{{ $URL_APP }}/recuperar-senha">Esqueceu sua senha? Clique aqui!</a>