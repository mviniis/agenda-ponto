$(() => {
  // PRIMEIRO PASSO PARA A RECUPERAÇÃO DE SENHA
  $(document).on('submit', '#primeiroPassoRecuperarSenha', function(event) {
    event.preventDefault();

    let form = $(this);
    let email = form.find('#email').val();

    $.ajax({
      url: URL_APP + '/recuperar-senha',
      method: 'POST',
      dataType: 'JSON',
      data: { email },
      success: data => {
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: data.mensagem,
          icon: 'success',
          confirmButtonText: 'Confirmar código',
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
            if (result.isConfirmed) {
              window.location.href = URL_APP + '/recuperar-senha/parte2';
            }
            if(result.isDenied){
              window.location.reload(true);
            }
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

  // SEGUNDO PASSO PARA A RECUPERAÇÃO DE SENHA
  $(document).on('submit', '#segundoPassoRecuperarSenha', function(event) {
    event.preventDefault();
    let codigo = $(this).find('#codigorec').val();

    $.ajax({
      url: URL_APP + '/recuperar-senha/parte2',
      method: 'POST',
      dataType: 'JSON',
      data: { codigo },
      success: data => {
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: data.mensagem,
          icon: 'success',
          confirmButtonText: 'Alterar senha',
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
            if (result.isConfirmed) {
              window.location.href = URL_APP + '/recuperar-senha/parte3';
            }
            if(result.isDenied){
              window.location.reload(true);
            }
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