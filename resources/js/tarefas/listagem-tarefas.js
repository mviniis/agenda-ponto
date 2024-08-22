/**
 * Armazena a instancia de preloader
 */
let preloaderPopup = false;

function excluirTarefa(idTarefa){
    $.ajax({
      url: URL_APP + '/remover-tarefa',
      data: {idTarefa},
      type: 'DELETE',
      dataType: 'JSON',
      success: function (data){
        let varsSwal = (data.status) ? {
          title: 'Sucesso!',
          text: 'Tarefa excluída com sucesso!',
          icon: 'success',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044"
        } : {
          title: 'Falha!',
          text: 'Houve um problema ao excluir a tarefa.',
          icon: 'error',
          confirmButtonText: 'Ok',
          confirmButtonColor: "#3fb044"
        };
        Swal.fire(varsSwal)
        .then((result) => {
          if (result.isConfirmed) {
            window.location.href = URL_APP + '/listagem-tarefas';
          }
        });
        return true;
      }
    })
}


function concluirTarefa(idTarefa){
  $.ajax({
    url: URL_APP + '/concluir-tarefa',
     data: {idTarefa},
     type: 'POST',
     dataType: 'JSON',
     success: function (data){
       let varsSwal = (data.status) ? {
         title: 'Sucesso!',
         text: 'Tarefa concluída com sucesso!',
         icon: 'success',
         confirmButtonText: 'Ok',
         confirmButtonColor: "#3fb044"
       } : {
         title: 'Falha!',
         text: 'Houve um problema ao concluir a tarefa.',
         icon: 'error',
         confirmButtonText: 'Ok',
         confirmButtonColor: "#3fb044"
       };
       Swal.fire(varsSwal)
       .then((result) => {
         if (result.isConfirmed) {
           window.location.href = URL_APP + '/listagem-tarefas';
         }
       });
       return true;
     }
  })
}

// EXCLUSÃO DA TAREFA
$(document).on('click', '.removerTarefa', function(){

    let idTarefa = $(this).closest('.acoes-tarefa').attr('data-idTarefa');

    Swal.fire({
      title: "Atenção!",
      text: 'Tem certeza que deseja excluir a tarefa?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Não',
      cancelButtonColor: "#f23434",
      confirmButtonText: 'Sim',
      confirmButtonColor: "#3fb044"
    }).then((result) => {
        if (result.isConfirmed) {
          excluirTarefa(idTarefa);
        }
    });
  });

// CONCLUSÃO DA TAREFA
$(document).on('click', '.concluirTarefa', function(){

  let idTarefa = $(this).closest('.acoes-tarefa').attr('data-idTarefa');

  Swal.fire({
    title: "Atenção!",
    text: 'Tem certeza que deseja concluir a tarefa?',
    icon: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Não',
    cancelButtonColor: "#f23434",
    confirmButtonText: 'Sim',
    confirmButtonColor: "#3fb044"
  }).then((result) => {
      if (result.isConfirmed) {
        concluirTarefa(idTarefa);
      }
  });
});