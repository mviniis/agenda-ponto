<a href="{{ $URL_APP }}/cadastrar-tarefa" class="conteudo_cadastrartarefa position-fixed bottom-0 end-0 p-4" data-placement="top" title="Cadastrar tarefa">
  <img src="{{ $URL_IMG }}/geral/icone_cadastrar_tarefa.png" style="width: 60px; height: 60px;" alt="Cadastrar Tarefa Icone" class="w">
</a>


<div class="container my-5 conteudo_containertarefa">
  <div class="conteudo_containertarefa_linha_cabecalho">
    <h6>Nome</h6>
    <h6>Responsável</h6>
    <h6>Prioridade</h6>
    <div class="conteudo_containertarefa_cabecalho_acoes">
      <h6>Ações</h6>
    </div>
  </div>

  @foreach ($tarefasUsuario as $tarefa)
  <div class="conteudo_containertarefa_linha">
    <span>{{$tarefa->nome}}</span>
    <h6>{{$tarefa->responsavel}}</h6>
    <h6>{{$tarefa->prioridade}}</h6>
    <div class="conteudo_containertarefa_linha_acoes">
      <a href="{{ $URL_APP }}/editar-tarefa/{{$tarefa->id}}" class="conteudo_containertarefa_linha_acoes_botoes">Editar</a>
      <a href="#" class="conteudo_containertarefa_linha_acoes_botoes">Remover</a>
      <a href="#" class="btn btn-dark">Concluir</a>
    </div>
  </div>
  @endforeach
  @isset($paginacao)
  <nav aria-label="Page navigation example" class="paginacao">
    <ul class="pagination">
      @foreach($paginacao->paginacao as $pagina)
        @if($pagina->active == 'true')
          <li class="page-item active"><a class="page-link" href="{{$pagina->url}}">{{$pagina->page}}</a></li>
        @else
          <li class="page-item"><a class="page-link" href="{{$pagina->url}}">{{$pagina->page}}</a></li>
        @endif
      @endforeach
    </ul>
  </nav>
  @endisset
</div>