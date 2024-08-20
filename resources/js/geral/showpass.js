function MostraSenha() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.src = "https://img.icons8.com/ios-glyphs/30/000000/invisible.png"; // Ícone de ocultar
    } else {
        passwordInput.type = 'password';
        toggleIcon.src = "https://img.icons8.com/ios-glyphs/30/000000/visible.png"; // Ícone de mostrar
    }
}
function toggleForms() {
    var cnpjCheckbox = document.getElementById('cnpjCheckbox');
    var cpfForm = document.querySelector('.cpf_form');
    var cnpjForm = document.querySelector('.cnpj_form');
  
    if (cnpjCheckbox.checked) {
      cpfForm.style.display = 'none';
      cnpjForm.style.display = 'block';
    } else {
      cpfForm.style.display = 'block';
      cnpjForm.style.display = 'none';
    }
  }
  