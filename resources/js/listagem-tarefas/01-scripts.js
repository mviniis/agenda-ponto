$(function() {
  $(document).on('click', '[data-action-logout]', () => {
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