$(() => {
  $(document).on('submit', '#cadastroUsuario', function(event) {
    event.preventDefault();

    // DADOS DO FORMULÁRIO
    let form         = $(this);
    let pessoaFisica = !form.find('#cnpjCheckbox').prop('checked');

    // MONTA OS DADOS PARA ENVIO
    let dadosEnviar = {
      pessoa: {
        pessoaFisica: pessoaFisica,
        email       : form.find('#email').val(),
        documento   : pessoaFisica ? form.find('#cpf').val()       : form.find('#cnpj').val(),
        nome        : pessoaFisica ? form.find('#nome').val()      : form.find('#razaosocial').val(),
        sobrenome   : pessoaFisica ? form.find('#sobrenome').val() : form.find('#nomefantasia').val(),
      },
      usuario: {
        senha: form.find('#password').val()
      },
      telefone: form.find('#tel').val()
    };

    $.ajax({
      url: URL_APP + '/cadastro',
      method: 'POST',
      dataType: 'JSON',
      data: { dadosEnviar },
      success: data => {
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: data.mensagem,
          icon: 'success',
          confirmButtonText: 'OK',
          confirmButtonColor: "#ec873b",
        } : {
          title: 'Falha!',
          text: data.mensagem,
          icon: 'error',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044"
        };
        
        Swal.fire(varsSwal)
          .then((result) => {
            if (result.isConfirmed) window.location.href = URL_APP + '/';
          }
        );
      },
      error: error => {
        let response = error.responseJSON;
        let mensagem = "Um erro inesperado aconteceu! Tente novamente mais tarde.";
        if(response.mensagem	!== undefined) mensagem = response.mensagem;

        let varsSwal = {
          title: 'Falha!',
          text: mensagem,
          icon: 'error',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044"
        };

        Swal.fire(varsSwal);
      }
    });
  });
});