<h1>Listagem de tarefas</h1>

<a href="{{ $URL_APP }}/cadastrar-tarefa">Cadastrar tarefa</a>
<a href="{{ $URL_APP }}/editar-perfil">Editar perfil</a>

<div class="container my-5">
  @for ($i = 0; $i < 10; $i++)
    <div class="row">
      <span>Tarefa do ID {{ $i + 1 }}</span>
      <a href="{{ $URL_APP }}/editar-tarefa/{{ $i + 1 }}">Editar</a>
      <a href="{{ $URL_APP }}/remover-tarefa/{{ $i + 1 }}">Remover</a>
    </div>
  @endfor
</div>