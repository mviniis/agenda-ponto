<div class="containe">
    <div class="lado-esquerdo">
        <div class="logo">
            <img src="{{ $URL_IMG }}/geral/logoagendaponto-bonline.svg" style="width: 25vw; height: auto;"
                alt="AgendaPonto Logo" class="w">
        </div>
    </div>
    <div class="lado-direito">
        <div class="caixa-de-login">
            <h2>Login</h2>
            <form action="#" method="POST" id="formulario-de-login">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floating1" placeholder="name@example.com">
                    <label for="floating1">Usuário</label>
                </div>
                <div class="form-floating position-relative">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password"><img src="{{ $URL_IMG }}/geral/cadeadosenha.svg"
                            style="width: 20px; height: auto; padding-right: 5px;" alt="AgendaPonto Logo"
                            class="w">Senha</label>
                    <span onclick="togglePasswordVisibility()" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                        <img id="toggleIcon" src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" alt="Mostrar senha" />
                    </span>
                </div>
                <div class="esqueceu-senha">
                    <a href="{{ $URL_APP }}/recuperar-senha">Esqueceu a senha?</a>
                </div>
                <button type="submit">ENTRAR</button>
            </form>
            <div class="criar-conta">
                <p>Não tenho conta? <a href="{{ $URL_APP }}/cadastro">Criar conta agora</a></p>
            </div>
        </div>
    </div>
</div>