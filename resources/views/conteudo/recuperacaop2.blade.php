<div class="containe">
  <div class="lado-esquerdo">
    <div class="logo">
      <img src="{{ $URL_IMG }}/geral/logoagendaponto-bonline.svg" style="width: 25vw; height: auto;"
        alt="AgendaPonto Logo" class="w">
    </div>
  </div>
  <div class="lado-direito">
    <div class="caixa-de-login">
      <h1>Recuperar senha</h1>
      <p>
        Para sua segurança, enviamos um código para o seu email de
        cadastro. Por favor, informe o código para prosseguir com a
        alteração de sua senha.
      </p>

      <form action="{{ $URL_APP }}/recuperar-senha" method="post" id="segundoPassoRecuperarSenha">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="codigorec" id="codigorec" placeholder="name@example.com">
          <label for="codigorec">Digite o código</label>
        </div>

        <br>
        
        <button type="submit">Enviar</button>
        
        <div class="criar-conta" style="overflow: hidden;margin-top: 1vh;">
          <p style='float: left; margin: 0;'><a href="{{ $URL_APP }}/">Efetuar login</a></p>
          <p style='float: right; margin: 0;'><a href="{{ $URL_APP }}/cadastro">Cadastre-se</a></p>
      </div>
      </form>
    </div>
  </div>
</div>