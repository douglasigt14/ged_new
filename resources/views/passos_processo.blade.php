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
                                            data-target="#modalStatus" 
                                            onclick="mostrarModal(event)"
                                            data-item-id={{$item->id}}
                                            data-item-descricao='{{$item->nome}}'
                                            class='btn btn-sm btn-primary'> <i class="fa fa-th-list"></i> </button></center>
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
        <h5 class="modal-title" id="exampleModalLabel"><span id="item-descricao"></span> Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/passos_processo" method="post">
          @method('patch')
          @csrf
         <div class="row">
           <div class="col col-md-12">
             <select name='status_id' class="form-control">
               @foreach ($status as $item)
                   <option value="{{$item->id}}">{{$item->descricao}}</option>
               @endforeach
              </select>
              <input type="hidden" name="passo_id" id="item-id">
           </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Vincular</button>
        </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
    <script>
         function mostrarModal(event) {
                console.log('Douglas');
                const button = event.currentTarget
                const descricao = document.querySelector("#modalStatus #item-descricao")
                const id = document.querySelector("#modalStatus #item-id")

                descricao.innerHTML = button.getAttribute("data-item-descricao")
                id.value = button.getAttribute("data-item-id")
            }
    </script>
@endpush
@endsection