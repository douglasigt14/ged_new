@extends('commons.template')

@section('conteudo')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-headline">
						<div class="panel-heading">
                            <div class="row">
                                <div class="col col-md-8">
                                    <h3 class="panel-title">Documentos - <span class='negrito'>{{ucfirst($setor)}}</span></h3>
                                </div>
                                 <div class="col col-md-2">
                                    <label>Outros Setores</label><br>
                                    <input id="toggle-outros_setores" type="checkbox" data-toggle="toggle" data-on="SIM <i class='fa fa-eye'></i>" data-off="&nbsp;&nbsp;&nbsp;NÃO <i class='fa fa-eye-slash'></i>" data-onstyle="success" data-offstyle="danger"  @if ($outros_setores_checked) checked @endif>
                                   
                                </div>
                                <div class="col col-md-2">
                                    <label>Finalizados</label><br>
                                    <input id="toggle-finalizados" type="checkbox" data-toggle="toggle" data-on="SIM <i class='fa fa-eye'></i>" data-off="&nbsp;&nbsp;&nbsp;NÃO <i class='fa fa-eye-slash'></i>" data-onstyle="success" data-offstyle="danger"  @if ($finalizados_checked) checked @endif>
                                </div>
                            </div>
							
						</div>
						<div class="panel-body">
                           

                            <form action="/documentos" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Documento</label>
                                        <input type='file'  name="documento"  class="dropify" data-height="100" required>
                                    </div>
                                    <div class="col-md-9">
                                        <label>Descrição</label>
                                        <input type='text' autocomplete="off" name="descricao" class='form-control' required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button class='btn btn-block btn-primary'>Enviar</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                             <div class="row">
                                <div class="col-md-12">
                                    @if($lista_arquivos)
                                    <hr class='linha'>
                                    @foreach ($lista_processo as $processo)
                                    <h4><b>{!! $processo !!}</b></h4>
                                    <table class="table table-striped menor myTable">
                                        <thead>
                                            <tr>
                                                <th>Descrição</th>
                                                <th>Set.Anterior</th>
                                                <th>Set.Atual</th>
                                                <th class='center'>Status</th>
                                                <th class='center'>Arquivo</th>
                                                <th class='center'>Anexos&nbsp;e&nbsp;Obs</th>
                                                <th class='center'>Desenho&nbsp;Fluxo</th>
                                                <th class='center'>Hist.&nbsp;Mov.</th>
                                                <th class='center'>Seguir&nbsp;Fluxo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lista_arquivos as $item)
                                                @if ($item->descricao_processo != $processo and ($item->tipo_passo != 'BPMN:EXCLUSIVEGATEWAY' and $item->tipo_passo != 'EXCLUSIVEGATEWAY'))
                                                    @php continue; @endphp
                                                @endif
                                                @if ($item->descricao_processo != $processo and ($item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY' or $item->tipo_passo == 'EXCLUSIVEGATEWAY') )
                                                    @php continue; @endphp
                                                @endif
                                            <tr>
                                                <td>
                                                    {{$item->descricao }}
                                                </td>
                                                <td>{{ $item->setor_anterior }}</td>
                                                <td @if ($item->setor_atual == $setor)
                                                     class='negrito'   
                                                    @endif>{{ $item->setor_atual }}</td>
                                                <td><center><p 
                                                                @if (($item->setor_atual == $setor or ($item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY' or $item->tipo_passo == 'EXCLUSIVEGATEWAY')) and $item->finalizado != 1 )
                                                                    data-toggle="modal" 
                                                                    data-target="#modalStatus" 
                                                                    onclick="mostrarModalStatus(event)"
                                                                    data-item-id={{$item->id}}
                                                                    data-item-status_lista='{{json_encode($item->status_lista)}}'
                                                                @endif
                                                                style="background-color: {{$item->cor}};color: {{$item->cor_texto}}"
                                                                class="label label-warning status-span">
                                                    {{$item->status_desc}}</p></center></td>
                                                <td class='menor'>
                                                    <center><a target='_blank' href='{{$item->caminho}}' class="btn btn-sm btn-success"><i class="fa fa-file"></i></a></center> 
                                                </td>
                                                <td>
                                                     <center><a href='/anexos_obs/{{$item->id}}'  class="btn btn-sm btn-primary cinza-ardosia"><i class="fa fa-paperclip"></i></button></a>
                                                </td>
                                                <td>
                                                    <center><button 
                                                        data-toggle="modal" 
                                                        data-target="#modalImg" 
                                                        onclick="mostrarModalImg(event)"
                                                        data-item-id={{$item->id}}
                                                        data-item-img='{{$item->caminho_svg.'?'.date("YmdHis")}}'
                                                        class="btn btn-sm btn-info"><i class="fa fa-file-image-o"></i></button></center>
                                                </td>

                                                <td>
                                                     <center><a href='/hist_mov/{{$item->id}}'  class="btn btn-sm btn-warning"><i class="fa fa-file-text"></i></button></a>
                                                </td>
                                                
                                                <form action="/seguir_fluxo" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <input type="hidden" name="setor_atual_id" value="{{$item->setor_atual_id}}"> 
                                                        <input type="hidden" name="passo_processo_id" value="{{$item->passo_processo_id}}">
                                                        <input type="hidden" name="processo_id" value="{{$item->processo_id}}">
                        
                                                <td>
                                                    @if ($item->setor_atual == $setor and $item->finalizado != 1)
                                                        <center><button type='submit' class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></button></center>
                                                    @elseif (($item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY' or $item->tipo_passo == 'EXCLUSIVEGATEWAY'))
                                                        <center><button 
                                                            data-toggle="modal" 
                                                            data-target="#modalDecissao" 
                                                            onclick="mostrarModalDecisao(event)"
                                                            data-item-id={{$item->id}}
                                                            data-item-pergunta="{{$item->nome_passo}}"
                                                            data-item-processo_id="{{$item->processo_id}}"
                                                            data-item-setor_atual_id="{{$item->setor_anterior_id}}"
                                                            data-item-bifurcacoes='{{json_encode($item->bifurcacoes)}}'
                                                            type='button' class="btn btn-sm btn-warning laranja-escuro"><i class="fa fa-arrows-alt"></i></button></center>
                                                    @else
                                                      
                                                    @endif
                                                </td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <hr class='linha'>
                                    @endforeach
                                    @endif
                                    @if($lista_arquivos_geral)
                                    <h4><b>Arquivos sem processo atribuido</b></h4>
                                    <table class="table table-striped menor mytable">
                                        <thead>
                                            <tr>
                                                <th class='center'>Apagar</th>
                                                <th>Descrição</th>
                                                <th class='center'>Selecionar</th>
                                                <th class='center'>Status</th>
                                                <th class='center'>Arquivo</th>
                                                <th class='center'>Iniciar Fluxo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lista_arquivos_geral as $item)
                                            <tr>
                                                 <td>
                                                  <form action="/documentos" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value={{$item->id}}>
                                                    
                                                    <center><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
                                                  </form>
                                                </td>
                                                <td>
                                                    {{$item->descricao}}
                                                </td>
                                               
                                                <td>
                                                <form action="/seguir_fluxo" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <input type="hidden" name="passo_processo_id" value="0">
                                
                            
                                                    <select name="processo_id" required class="form-control">
                                                        <option></option>
                                                        @foreach ($processos as $processo)
                                                            <option value="{{$processo->id}}">{{$processo->descricao}}</option>
                                                        @endforeach
                                                    </select></td>
                                                <td>{!! $item->status !!}</td>
                                                 <td class='menor'>
                                                    <center><a target='_blank' href='{{$item->caminho}}' class="btn btn-sm btn-success"><i class="fa fa-file"></i></a></center> 
                                                </td>
                                                <td><center><button class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></button></center></td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    @endif
                                </div>
                            </div>
                       </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Imagem</h4>
      </div>
      <div class="modal-body">
          <div class="row">
             <div class="col col-md-12">
                    <source id="item-source-img" srcset="" type="image/svg+xml">
                    <img id="item-img" src="" class="img-fluid img-thumbnail" alt="...">
             </div>
          </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


   <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Alterar Status</h4>
      </div>
      <div class="modal-body">
          <form action="/documentos" method="POST">
            @csrf
            @method('patch')
          <div class="row">
              <input type="hidden" name='id' id='item-id'>
             <div class="col col-md-12">
                <select class='form-control' name="status_id" id="item-status_lista">
                    
                </select>
             </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class='btn btn-warning'>Alterar</button>
      </form>
      </div>
    </div>
  </div>
</div>


  <div class="modal fade" id="modalDecissao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Decissão</h4>
      </div>
      <div class="modal-body">
          <div class="row">
             <div class="col col-md-12">
                <h4 class='center' id='item-pergunta'></h4>
                <form action="/seguir_fluxo" method="post">
                @csrf
                <input type="hidden" name="setor_atual_id" id="item-setor_atual_id"> 
                <input type="hidden" name="processo_id" id="item-processo_id">
                <input type="hidden" name="tem_bifurcacao" value=1>
                <input type="hidden" name='id' id='item-id'>
                <select class='form-control' name="passo_processo_id" id="item-bifurcacoes">
            
                </select>
             </div>
          </div>
      </div>
      <div class="modal-footer">
            <button type="submit" class='btn btn-warning laranja-escuro'>Selecionar</button>
            </form>
      </div>
    </div>
  </div>
</div>
           
@endsection

@push('scripts')
        <script src="{{url('js/documentos.js')}}"> </script>
@endpush 