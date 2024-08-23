function MostraSenha() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


function toggleForms() {
  var cnpjCheckbox = document.getElementById('cnpjCheckbox');
  var cpfForm      = document.querySelector('.cpf_form');
  var cnpjForm     = document.querySelector('.cnpj_form');

  if (cnpjCheckbox.checked) {
    cpfForm.style.display = 'none';
    cnpjForm.style.display = 'block';
  } else {
    cpfForm.style.display = 'block';
    cnpjForm.style.display = 'none';
  }
}

$(document).on('click', '[data-alterar-visibilidade-senha]', function() {
  let elemento      = $(this);
  let elementoPai   = elemento.parent();
  let inputPassword = $(elementoPai.find(elemento.data('alterar-visibilidade-senha')));
  let elementoIcone = elemento.find('#toggleIcon');

  if(inputPassword.attr('type') === 'password') {
    inputPassword.attr('type', 'text');
    elementoIcone.attr('src', 'https://img.icons8.com/ios-glyphs/30/000000/invisible.png');
  } else {
    inputPassword.attr('type', 'password');
    elementoIcone.attr('src', 'https://img.icons8.com/ios-glyphs/30/000000/visible.png');
  }
});
  