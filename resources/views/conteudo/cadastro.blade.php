<div class="containe">
  <div class="lado-esquerdo">
    <div class="logo">
      <img src="{{ $URL_IMG }}/geral/logoagendaponto-bonline.svg" style="width: 25vw; height: auto;"
        alt="AgendaPonto Logo" class="w">
    </div>
  </div>
  <div class="lado-direito">
    <div class="caixa-de-login">
      <h1>Cadastrar usuário</h1>
      <form action="{{ $URL_APP }}/cadastro" method="post">
        @csrf
        <div class="form-check mb-2 align-left">
          <input class="form-check-input custom-checkbox" type="checkbox" value="" id="cnpjCheckbox" onclick="toggleForms()">
          <label class="form-check-label" for="cnpjCheckbox">
            CNPJ
          </label>
        </div>
        <div class="cpf_form">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="email" id="cpf" placeholder="name@example.com">
            <label for="floating1">Digite seu CPF</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Seu nome">
            <label for="floating1">Digite seu nome</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="sobrenome" id="sobrenome" placeholder="Seu nome">
            <label for="floating1">Digite seu sobrenome</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
            <label for="floating1">Digite seu Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="email" id="tel" placeholder="name@example.com">
            <label for="floating1">Digite seu telefone</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password"><img src="{{ $URL_IMG }}/geral/cadeadosenha.svg"
                style="width: 20px; height: auto; padding-right: 5px;" alt="AgendaPonto Logo" class="w">Digite sua
              senha</label>
            <span onclick="togglePasswordVisibility()"
              style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
              <img id="toggleIcon" src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" alt="Mostrar senha" />
            </span>
          </div>
        </div>
        <div class="cnpj_form" style="display:none;">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="name@example.com">
            <label for="floating1">Digite o CPNJ</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" id="razaosocial" placeholder="Seu nome">
            <label for="floating1">Digite a razão social</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="sobrenome" id="nomefantasia" placeholder="Seu nome">
            <label for="floating1">Digite o nome fantasia</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
            <label for="floating1">Digite seu Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="email" id="tel" placeholder="name@example.com">
            <label for="floating1">Digite seu telefone</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password"><img src="{{ $URL_IMG }}/geral/cadeadosenha.svg"
                style="width: 20px; height: auto; padding-right: 5px;" alt="AgendaPonto Logo" class="w">Digite sua
              senha</label>
            <span onclick="togglePasswordVisibility()"
              style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
              <img id="toggleIcon" src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" alt="Mostrar senha" />
            </span>
          </div>
        </div>
        <br>
        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>
</div>