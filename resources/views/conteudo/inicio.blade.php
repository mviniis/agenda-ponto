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
                <div class="form-floating">
                    <input type="password" class="form-control" id="floating1" placeholder="Password">
                    <label for="floating1"><img src="{{ $URL_IMG }}/geral/cadeadosenha.svg" style="width: 20px; height: auto; padding-right: 5px;"
                    alt="AgendaPonto Logo" class="w">Senha</label>
                </div>
                <div class="esqueceu-senha">
                    <a href="#">Esqueceu a senha?</a>
                </div>
                <button type="submit">ENTRAR</button>
            </form>
            <div class="criar-conta">
                <p>Não tenho conta? <a href="#">Criar conta agora</a></p>
            </div>
        </div>
    </div>
</div>