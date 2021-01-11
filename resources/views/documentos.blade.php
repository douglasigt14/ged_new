@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Documentos - {{ucfirst($setor)}}</h3>
						</div>
						<div class="panel-body">
                            <form action="/documentos" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Documento</label>
                                        <input type='file' name="documento" class='form-control'>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Descrição</label>
                                        <input type='text' name="descricao" class='form-control'>
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
                                    @foreach ($lista_processo as $processo)
                                    <h4>{!! $processo !!}</h4>
                                    <table class="table table-striped menor">
                                        <thead>
                                            <tr>
                                                <th>Descrição</th>
                                                <th>Set.Anterior</th>
                                                <th>Set.Atual</th>
                                                <th class='center'>Processo</th>
                                                <th class='center'>Status</th>
                                                <th class='center'>Arquivo</th>
                                                <th class='center'>Anexos&nbsp;e&nbsp;Obs</th>
                                                <th class='center'>Desenho&nbsp;Fluxo</th>
                                                <th class='center'>Seguir&nbsp;Fluxo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lista_arquivos as $item)
                                                @if ($item->descricao_processo != $processo and $item->tipo_passo == 'BPMN:TASK')
                                                    @php continue; @endphp
                                                @endif
                                                @if ($item->descricao_processo != $processo and $item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY')
                                                    @php continue; @endphp
                                                @endif
                                            <tr>
                                                <td>
                                                    {{$item->descricao }}
                                                </td>
                                                <td>{{ $item->setor_anterior }}</td>
                                                <td>{{ $item->setor_atual }}</td>
                                                <td>{{$item->descricao_processo}}</td>
                                                <td><center><p 
                                                                @if ($item->setor_atual == $setor or $item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY')
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
                                                     <center><a target='_blank' href='anexos_obs/{{$item->id}}'  class="btn btn-sm btn-primary"><i class="fa fa-paperclip"></i></button></a>
                                                </td>
                                                <td>
                                                    <center><button 
                                                        data-toggle="modal" 
                                                        data-target="#modalImg" 
                                                        onclick="mostrarModalImg(event)"
                                                        data-item-id={{$item->id}}
                                                        data-item-img='{{$item->caminho_svg}}'
                                                        class="btn btn-sm btn-info"><i class="fa fa-file-image-o"></i></button></center>
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
                                                    @elseif ($item->tipo_passo == 'BPMN:EXCLUSIVEGATEWAY')
                                                        <center><button 
                                                            data-toggle="modal" 
                                                            data-target="#modalDecissao" 
                                                            onclick="mostrarModalDecisao(event)"
                                                            data-item-id={{$item->id}}
                                                            data-item-pergunta="{{$item->nome_passo}}"
                                                            data-item-processo_id="{{$item->processo_id}}"
                                                            data-item-setor_atual_id="{{$item->setor_anterior_id}}"
                                                            data-item-bifurcacoes='{{json_encode($item->bifurcacoes)}}'
                                                            type='button' class="btn btn-sm btn-warning"><i class="fa fa-arrows-alt"></i></button></center>
                                                    @else
                                                      
                                                    @endif
                                                </td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    @endforeach
                                    @endif
                                    @if($lista_arquivos_geral)
                                    <h4>Arquivos sem processo atribuido</h4>
                                    <table class="table table-striped menor">
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
            <button type="submit" class='btn btn-warning'>Selecionar</button>
            </form>
      </div>
    </div>
  </div>
</div>
           
@endsection

    @push('scripts')
		  <script>
			   function mostrarModalImg(event) {     
						const button = event.currentTarget
						const img = document.querySelector("#modalImg #item-img")
						const source_img = document.querySelector("#modalImg #item-source-img")
						console.log(img);

						img.srcset = button.getAttribute("data-item-img")
						source_img.src = button.getAttribute("data-item-img")
                }
                
                function mostrarModalStatus(event) {     
						const button = event.currentTarget
						const id = document.querySelector("#modalStatus #item-id")
						const status_lista = document.querySelector("#modalStatus #item-status_lista")

                        var lista = JSON.parse(button.getAttribute("data-item-status_lista")) 

                         var op = '';
                        lista.forEach(item => {
                            op = op+'<option value="'+item.id+'">'+item.descricao+'</option>';
                        });
                         status_lista.innerHTML = op;
                        
                        id.value = button.getAttribute("data-item-id")
                }
                function mostrarModalDecisao(event) {     
                    const button = event.currentTarget
                    const id = document.querySelector("#modalDecissao #item-id")
                    const pergunta = document.querySelector("#modalDecissao #item-pergunta")
                    const bifurcacoes = document.querySelector("#modalDecissao #item-bifurcacoes")
                    const processo_id = document.querySelector("#modalDecissao #item-processo_id")
                    const setor_atual_id = document.querySelector("#modalDecissao #item-setor_atual_id")

                    var lista = JSON.parse(button.getAttribute("data-item-bifurcacoes")) 

                     var op = '';
                    lista.forEach(item => {
                        op = op+'<option value="'+item.id+'">'+item.nome+'</option>';
                    });
                        bifurcacoes.innerHTML = op;

                    id.value = button.getAttribute("data-item-id")
                    pergunta.innerHTML = button.getAttribute("data-item-pergunta")
                    processo_id.value = button.getAttribute("data-item-processo_id")
                    setor_atual_id.value = button.getAttribute("data-item-setor_atual_id")
                    
                    
                }
		  </script>
	  @endpush 