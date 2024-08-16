// DEFINE O CSRF TOKEN PARA TODAS AS REQUISIÇÕES AJAX
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});