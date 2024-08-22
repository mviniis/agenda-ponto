function editarTarefa(dadosTarefa){

    var dadosJson = {};

     $.each(dadosTarefa, function(i, field) {
         dadosJson[field.name] = field.value;
     });

    $.ajax({
      url: URL_APP + '/editar-tarefa',
      data: dadosJson,
      type: 'POST',
      success: function (data){
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: data.mensagem,
          icon: 'success',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044",
          showDenyButton: true,
          denyButtonText: 'Ir para a listagem', 
          denyButtonColor: "#ec873b" 
        } : {
          title: 'Falha!',
          text: data.mensagem,
          icon: 'error',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044",
          showDenyButton: true, 
          denyButtonText: 'Ir para a listagem', 
          denyButtonColor: "#ec873b"
        };
        Swal.fire(varsSwal)
        .then((result) => {
          if (result.isConfirmed) {
            window.location.reload(true);
          }
          if(result.isDenied){
            window.location.href = URL_APP + '/listagem-tarefas';
          }
        });
        return true;
      }
    })
  }


// EXCLUSÃO DA TAREFA
$('.editarTarefaForm').on('submit', function(event){
    event.preventDefault();

    var dadosTarefa = $(this).serializeArray();
    
    editarTarefa(dadosTarefa);
  });