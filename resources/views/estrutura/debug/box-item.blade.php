<div class="card bg-dark text-light mb-2">
  <div class="card-header" id="headingOne">
    <h2 class="mb-0">
      <button  class="btn text-left text-white d-flex align-items-center" 
        type="button" data-toggle="collapse" data-target="#{{ $indiceItem }}" aria-expanded="true" aria-controls="{{ $indiceItem }}"
      >
        <span> <b>Nome do índice:</b> {{ $nomeCabecalho }} </span>
        <span class="material-symbols-outlined"> arrow_drop_down </span>
      </button>
    </h2>
  </div>

  <div id="{{ $indiceItem }}" class="collapse" aria-labelledby="headingOne" data-parent="#{{ $hashParent }}">
    <div class="card-body"> {!! $valorCabecalho !!} </div>
  </div>
</div>