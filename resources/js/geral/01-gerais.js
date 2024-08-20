$(() => {
  console.log('teste 1');
  
  // DEFINE O CSRF TOKEN PARA TODAS AS REQUISIÇÕES AJAX
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});

// LOGOUT DO USUÁRIO
$(function() {
  $(document).on('click', '[data-action-logout]', () => {
    console.log('teste 2');
    
    $.ajax({
      url: URL_APP + '/logout',
      method: 'POST',
      dataType: 'JSON',
      success: data => {
        if(data.status) window.location = URL_APP;
      }
    });
  });
});