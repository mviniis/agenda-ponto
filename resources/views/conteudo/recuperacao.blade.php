<h1>Recuperação de senha</h1>

<form action="{{ $URL_APP }}/recuperar-senha" method="post">
  @csrf

  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email">
  </div>

  <button type="submit">Enviar</button>
</form>

<a href="{{ $URL_APP }}/">Efetuar login</a>
<a href="{{ $URL_APP }}/cadastro">Cadastre-se</a>