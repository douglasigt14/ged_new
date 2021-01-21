@extends('commons.template')


@section('conteudo')
<div class="panel">
                <div class="panel-heading">
                    <h3>Configurações</h3>
                    <h4>Documento: {{$doc_descricao}}</h4>
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
                                <div class="col col-md-10">
                                    <label>Editar descrição</label>
                                    <input type="text" autocomplete="off" name='descricao' value="{{$doc_descricao}}" class="form-control" required>
                                </div>
                                <div class="col col-md-2">
                                    <label>&nbsp;</label>
                                    
                                    <button class="btn btn-warning btn-block" @if(!$doc_descricao) disabled @endif>Editar</button>
                                </div>
                            </form>
                        </div>
                    </div><br>
                        <div class="row">
                            <div class="panel-heading">
                    <h4>Versões do Documento</h4>
                </div>
                            
                            <div class="col col-md-6">
                        
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class='center'>#</th>
                                                 <th>Observação</th>
                                                 <th>Data e Hora do Upload</th>
                                                <th class='center'>Arquivo</th>
                                                <th class='center'>Principal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($log_documentos as $key => $item)
                                            <tr>
                                                <td class='center'>{{$key+1}}</td>
                                                <td>{{$item->obs}}</td>
                                                <td>{{$item->systemdate}}</td>
                                                <td> <center><a target='_blank' href='{{$item->caminho}}' class="btn btn-sm btn-success cinza-ardosia"><i class="fa fa-file"></i></a></center> </td>
                                                <td> <center> <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" @if($item->is_principal)checked @endif> </center>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                            </div>
                             <div class="col col-md-6">
                                 
                            <form action="/config" method="post" enctype="multipart/form-data">
                                <input type="hidden" name='usuario_id' value="{{$_SESSION['id']}}">
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