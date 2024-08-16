$(function() {
  // AJAX DE LOGIN
  $(document).on('submit', '#formulario-de-login', (event) => {
    event.preventDefault();
    const formularioLogin = $(event.currentTarget);

    // OBTEM OS DADOS DO FORMULÁRIO
    let email = formularioLogin.find('[type="email"]').val();
    let senha = formularioLogin.find('[type="password"]').val();
    
    // CHAMADA O AJAX DE LOGIN
    chamadaSpinnerLogin();
    $.ajax({
      url: URL_APP + '/',
      method: 'POST',
      dataType: 'JSON',
      data: {
        email, senha
      },
      success: data => {
        let callback = data.status ? () => window.location = URL_APP + '/listagem-tarefas': undefined;
        exibirAlerta(data.mensagem, data.status, callback);
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
    setTimeout(() => chamadaSpinnerLogin(false), 5000);
  });
});

function chamadaSpinnerLogin(habilitar = true) {
  const spinner = $('[data-spinner-login]');

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