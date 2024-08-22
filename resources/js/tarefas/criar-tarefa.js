function criarTarefa(dadosTarefa){

    var dadosJson = {};

     $.each(dadosTarefa, function(i, field) {
         dadosJson[field.name] = field.value;
     });

    $.ajax({
      url: URL_APP + '/cadastrar-tarefa',
      data: dadosJson,
      type: 'POST',
      success: function (data){
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: data.mensagem,
          icon: 'success',
          confirmButtonText: 'Ir para a listagem',
          confirmButtonColor: "#ec873b",
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
            window.location.href = URL_APP + '/listagem-tarefas';
          }
          if(result.isDenied){
            window.location.reload(true);
          }
        });
        return true;
      }
    })
  }


// EXCLUSÃO DA TAREFA
$('.criarTarefaForm').on('submit', function(event){
    event.preventDefault();

    var dadosTarefa = $(this).serializeArray();
    
    criarTarefa(dadosTarefa);
});