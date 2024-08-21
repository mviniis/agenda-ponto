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
      <form action="{{ $URL_APP }}/recuperar-senha" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Digite sua nova senha</label>
            <span onclick="togglePasswordVisibility()"
              style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
              <img id="toggleIcon" src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" alt="Mostrar senha" />
            </span>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="passwordconfirm" placeholder="PasswordConfirm">
            <label for="passwordConfirm">Confirme sua nova senha</label>
            <span onclick="togglePasswordVisibility()"
              style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
              <img id="toggleIcon" src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" alt="Mostrar senha" />
            </span>
          </div>
        <button type="submit">Enviar</button>
        <div class="criar-conta" style="overflow: hidden;margin-top: 1vh;">
          <p style='float: left; margin: 0;'><a href="{{ $URL_APP }}/">Efetuar login</a></p>
          <p style='float: right; margin: 0;'><a href="{{ $URL_APP }}/cadastro">Cadastre-se</a></p>
      </div>
      </form>
    </div>
  </div>
</div>