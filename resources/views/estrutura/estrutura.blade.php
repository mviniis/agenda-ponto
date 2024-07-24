<!DOCTYPE html>
<html lang="pt-br">
  @include('estrutura.head', $app)
  
  <body>
    @include('estrutura.header', $app)
    
    @include('conteudo.' . $hashConteudo, $app)

    @include('estrutura.footer', $app)
  </body>
</html>