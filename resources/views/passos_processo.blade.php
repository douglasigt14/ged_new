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
                          
                         <div class="col col-md-7">
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
                          <div class="col col-md-5">
                                <h4>Etapas</h4>
                                <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($passos_processo as $item)
                                  <tr>
                                      <td>{{$item->tipo }}</td>
                                      <td>{{$item->nome }}</td>
                                      <td>
                                        @if ($item->tipo == 'SETOR')
                                        {{-- <center><button 
                                            data-toggle="modal" 
                                            data-target="#modalStatus" 
                                            onclick="mostrarModal(event)"
                                            data-item-id={{$item->id}}
                                            data-item-descricao='{{$item->nome}}'
                                            data-item-status_lista='{{json_encode($item->status_lista)}}'
                                            data-item-status_lista_selecionados='{{json_encode($item->status_lista_selecionados)}}'
                                            class='btn btn-sm btn-primary'> <i class="fa fa-th-list"></i> </button></center> --}}
                                        @endif
                                        @if ($item->tipo == 'DECISSÃO')
                                          <center><button 
                                            data-toggle="modal" 
                                            data-target="#modalDecisao" 
                                            onclick="mostrarModalDecissao(event)"
                                            data-item-id={{$item->id}}
                                            data-item-descricao='{{$item->nome}}'
                                            class='btn btn-sm btn-primary laranja-escuro'> <i class="fa fa-th-list"></i> </button></center> 
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
          @method('put')
          @csrf
         <div class="row">
           <div class="col col-md-12">
             <div id="div-item-status_id">
                 
              </div>
              
              <br>
              <div id="div-item-tabela">
                 
              </div>
              <input type="hidden" name="passo_id" id="item-id">
           </div>
         </div>
      </div>
      <div class="modal-footer">
        
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal Decisao -->
<div class="modal fade" id="modalDecisao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Gerenciar que decide essa bifurcação</h4>
        <h5><span id="item-descricao"></span></h5>
      </div>
      <div class="modal-body">
        <form action="/passos_processo" method="post">
          @method('patch')
          @csrf
         <div class="row">
           <div class="col col-md-12">
              <input type="text" name="passo_id" id="item-id">
               <select name="setor_id" required class="form-control">
                    @foreach ($setores as $setor)
                        <option value="{{$setor->id}}">{{$setor->descricao}}</option>
                    @endforeach
                </select>
           </div>
         </div>
      </div>
      <div class="modal-footer">
         <button type='submit' class='btn btn-primary laranja-escuro'>Selecionar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
        <script src="{{url('js/passos_processo.js')}}"> </script>
@endpush
@endsection