$(() => {
  $('[name="telefone"]').inputmask({
    mask: ["(99) 9999-9999", "(99) 99999-9999", ],
    keepStatic: true
  });

  $(document).on('submit', '#editarPerfil', event => {
    event.preventDefault();
    const formularioLogin = $(event.currentTarget);

    chamadaSpinnerLogin();

    // OBTEM OS DADOS DO FORMULÁRIO
    let dadosFormulario       = {};
    dadosFormulario.email     = formularioLogin.find('[name="email"]').val();
    dadosFormulario.nome      = formularioLogin.find('[name="nome"]').val();
    dadosFormulario.sobrenome = formularioLogin.find('[name="sobrenome"]').val();
    dadosFormulario.telefone  = formularioLogin.find('[name="telefone"]').val();

    // REALIZA O ENVIO DO FORMULÁRIO
    $.ajax({
      url: URL_APP + '/editar-perfil',
      method: 'POST',
      dataType: 'JSON',
      data: dadosFormulario,
      success: data => {
        exibirAlerta(data.mensagem, true);
      },
      error: error => {
        let response = error.responseJSON;
        let mensagem = "Um erro inesperado aconteceu! Tente novamente mais tarde.";
        if(response.mensagem	!== undefined) mensagem = response.mensagem;
        exibirAlerta(mensagem, false);
      },
      complete: () => {
        chamadaSpinnerLogin(false);
      }
    });
  });
});

function chamadaSpinnerLogin(habilitar = true) {
  const spinner = $('[data-spinner-editar-usuario]');
  habilitar ? spinner.removeClass('d-none'): spinner.addClass('d-none');
}

function exibirAlerta(mensagem, sucesso = true, callback = undefined) {
  const boxAlerta = $('[data-alerta-login]');

  // MONTA E MOSTRA O ALERTA
  let tipo = sucesso ? 'alert-success': 'alert-danger';
  boxAlerta.html(mensagem);
  boxAlerta.addClass(tipo);
  boxAlerta.removeClass('d-none');
  setTimeout(() => {
    boxAlerta.removeClass(tipo);
    boxAlerta.addClass('d-none')

    if(callback !== undefined) callback(); 
  }, 2000);
}