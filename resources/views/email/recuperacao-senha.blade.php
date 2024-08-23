<!DOCTYPE html>
<html>
  <head>
    <title>Bem-vindo ao {{ $appName }}</title>
  </head>

  <body>
    <h1>Olá, {{ $nome }}!</h1>

    <p>Utilize o código abaixo para realizar a confirmação do seu e-mail antes de recuperar a sua senha.</p>

    <p><i>{{ $codigo }}</i></p>

    <h4>Fique atento!!</h4>
    <p>Esse código de verificação expira às <strong><i>{{ $dataExpiracao }}</i></strong></p>
  </body>
</html>