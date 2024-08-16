<h3>Listagem de tarefas</h3>

<div>
  <a href="{{ $URL_APP }}/cadastrar-tarefa" class="btn btn-outline-success">Cadastrar tarefa</a>
  <a href="{{ $URL_APP }}/editar-perfil" class="btn btn-outline-info">Editar perfil</a>
  <a class="btn btn-outline-danger" data-action-logout>Sair</a>
</div>

<div class="container my-5">
  @for ($i = 0; $i < 10; $i++)
    <div class="row">
      <span>Tarefa do ID {{ $i + 1 }}</span>
      <a href="{{ $URL_APP }}/editar-tarefa/{{ $i + 1 }}">Editar</a>
      <a href="#">Remover</a>
    </div>
  @endfor
</div>