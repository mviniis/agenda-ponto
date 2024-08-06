<h1>Início</h1>


<form action="{{ $URL_APP }}/" method="post">
  @csrf

  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email">
  </div>

  <div>
    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha">
  </div>

  <button type="submit">Enviar</button>
</form>