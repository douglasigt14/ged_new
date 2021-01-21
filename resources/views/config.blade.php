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
                    </div><br>
                    <div class="row">
                        <h4>Versões do Documento</h4>
                    </div>
                    
                </div>
            </div>
    
@endsection