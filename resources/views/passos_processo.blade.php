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
                                        <center><button 
                                            data-toggle="modal" 
                                            data-target="#modalStatus" class='btn btn-sm btn-primary'> <i class="fa fa-th-list"></i> </button></center>
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
<!-- Modal Status -->
<div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Alterar</button>
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