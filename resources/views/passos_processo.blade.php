@extends('commons.template')


@section('conteudo')
   
    <div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Passos Processo</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                          
                         <div class="col col-md-8">
                                <h4>Fluxo</h4>
                                <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>De</th>
                                    <th>Para</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($passos_processo_fluxo as $item)
                                  <tr>
                                      <td>{{$item->tipo }}</td>
                                      <td>{{$item->nome }}</td>
                                      <td>{{$item->nome_de }}</td>
                                      <td>{{$item->nome_para }}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                          </div>
                          <div class="col col-md-4">
                                <h4>Etapas</h4>
                                <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>Tipos&nbsp;Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($passos_processo as $item)
                                  <tr>
                                      <td>{{$item->tipo }}</td>
                                      <td>{{$item->nome }}</td>
                                      <td>
                                        @if ($item->tipo == 'SETOR')
                                        <center><button class='btn btn-sm btn-primary'> <i class="fa fa-th-list"></i> </button></center>
                                        @endif
                                      </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col col-md-6"></div>
                          <div class="col col-md-12">
                            <source srcset="{{$img}}" type="image/svg+xml">
                            <img src="{{$img}}" class="img-responsive center-block" alt="...">
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="modalInserir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Inserir</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/setores" method="post">
              @csrf
              <div class="col col-md-6">
                  <label>Setor</label>
                  <input type="text" name='descricao' class='form-control'>
              </div>
              <div class="col col-md-6">
                  <label>Pasta</label>
                  <input type="text" name='pasta' class='form-control'>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Inserir</button>
      </form>
      </div>
    </div>
  </div>
</div>


   <!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/setores" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-6">
                  <label>Setor</label>
                 
                   <input type="text" id='item-descricao' name='descricao' class='form-control'>
              </div>
              <div class="col col-md-6">
                  <label>Pasta</label>
                  <input type="text" id='item-pasta' name='pasta' class='form-control'>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Editar</button>
      </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
    <script>
         function mostrarModal(event) {
                const button = event.currentTarget
                const pasta = document.querySelector("#modalEditar #item-pasta")
                const descricao = document.querySelector("#modalEditar #item-descricao")
                const id = document.querySelector("#modalEditar #item-id")

                pasta.value = button.getAttribute("data-item-pasta")
                descricao.value = button.getAttribute("data-item-descricao")
                id.value = button.getAttribute("data-item-id")
            }
    </script>
@endpush
@endsection