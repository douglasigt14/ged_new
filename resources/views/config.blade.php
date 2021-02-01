@extends('commons.template')


@section('conteudo')
<div class="panel">
                <div class="panel-heading">
                    <h3>Configurações</h3>
                    <h4>Documento: <span class='negrito'>{{$doc_descricao}}</span></h4>
                </div>
                <div class="panel-body">
                    @if (\Session::has('sucesso-descricao'))
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>	
								<strong>{!! \Session::get('sucesso-descricao') !!}</strong>
						</div>
					@endif
                    <div class="row">
                        <div class="col col-md-12">
                            <form action="/config" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value={{$documento_id}}>
                                <div class="col col-md-8">
                                    <label>Descrição</label>
                                    <input type="text" autocomplete="off" name='descricao' value="{{$doc_descricao}}" class="form-control" required>
                                </div>
                                <div class="col col-md-4">
                                    <label>Data de Vencimento</label>
                                    <input type="date" autocomplete="off" name='dt_vencimento' value="{{$dt_vencimento}}" class="form-control" >
                                </div>
                                <br>
                                <div class="col col-md-6">
                                    <label>Num Pedido</label>
                                    <input type="text" autocomplete="off" name='num_pedido' value="{{$num_pedido}}" class="form-control" >
                                </div>
                                
                                <div class="col col-md-6">
                                    <label>Empresa</label>
                                    <select name="empr_id" class="form-control">
                                        <option value=""></option>
                                        @foreach ($empresas as $item)
                                            <option value="{{$item->id}}" @if($item->id == $empr_id) selected @endif>{{$item->razao_social}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col col-md-2">
                                    <label>&nbsp;</label>
                                    @if($dados_pedido)
                                        <button 
                                        data-toggle="modal" 
                                        data-target="#modalDadosPedido" 
                                        type='button' class="btn btn-info btn-block">Dados Pedido</button>
                                    @endif
                                </div>
                                <div class="col col-md-8"></div>
                                    
                                <div class="col col-md-2">
                                    <label>&nbsp;</label>
                                    
                                    <button type='submit' class="btn btn-warning btn-block" @if(!$doc_descricao) disabled @endif>Editar</button>
                                </div>
                            </form>
                        </div>
                    </div><br>
                        <div class="row">
                            <div class="panel-heading">
                    <h4>Versões do Documento</h4>
                </div>
                            
                            <div class="col col-md-6">
                                <form action="/config" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                     <input type="hidden" name="id" value={{$documento_id}}>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class='center'>#</th>
                                                 <th>Observação</th>
                                                <th class='center'>Arquivo</th>
                                                <th class='center'>Principal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($log_documentos as $key => $item)
                                            <tr>
                                                <td class='center'>{{$key+1}}</td>
                                                <td>{{$item->obs}}</td>
                                                <td> <center><a target='_blank' href='{{$item->caminho}}' class="btn btn-sm btn-success cinza-ardosia"><i class="fa fa-file"></i></a></center> </td>
                                                <td> <center> <input class="form-check-input" type="radio" name="log_documento_id" value="{{$item->id}}" @if($item->is_principal)checked @endif> </center>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button type='submit' class='btn btn-block btn-warning'>Alterar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                             <div class="col col-md-6">
                                 
                            <form action="/config" method="post" enctype="multipart/form-data">
                                <input type="hidden" name='usuario_id' value="{{$_SESSION['id']}}">
                                <input type="hidden" name="id" value={{$documento_id}}>
                            @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Documento</label>
                                        <input type='file'  name="documento"  class="dropify" data-height="100" required>
                                    </div>
                                    <div class="col-md-9">
                                        <label>Observação</label>
                                        <input type="text" name='obs' class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button class='btn btn-block btn-primary'>Enviar</button>
                                    </div>
                                </div>
                            </form>
                             </div>

                        </div>
                    
                </div>
            </div>

            <div class="modal fade" id="modalDadosPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel">Dados Pedido</h4>
                    </div>
                    <div class="modal-body">
                       
                    </div>
                    <div class="modal-footer">
                          <button class='btn btn-default' data-dismiss="modal">Fechar</button>
                    </div>
                  </div>
                </div>
              </div>

@endsection

@push('scripts')
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Arraste e solte um arquivo aqui ou clique',
                'replace': 'Arraste e solte ou clique para substituir',
                'remove':  'Remover',
                'error':   'Opa, algo errado aconteceu.'
            }
        });
    </script>
@endpush