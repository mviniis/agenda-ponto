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
        Primeiro, informe seu e-mail de cadastro para que possamos
        validá-lo e prosseguir com a alteração.
      </p>
      
      <form action="{{ $URL_APP }}/recuperar-senha" method="post" id="primeiroPassoRecuperarSenha">
        <div class="form-floating mb-3">
          <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
          <label for="floating1">Digite seu Email</label>
        </div>

        <br>

        <button type="submit" style="font-style: bold;">Enviar</button>

        <div class="criar-conta" style="overflow: hidden;margin-top: 1vh;">
          <p style='float: left; margin: 0;'><a href="{{ $URL_APP }}/">Efetuar login</a></p>
          <p style='float: right; margin: 0;'><a href="{{ $URL_APP }}/cadastro">Cadastre-se</a></p>
        </div>
      </form>
    </div>
  </div>
</div>