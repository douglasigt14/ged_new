@extends('commons.template')


@section('conteudo')
<div class="panel">
                <div class="panel-heading">
                    <h3>Configurações</h3>
                    <h4>Documento: {{$doc_descricao}}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col col-md-10">
                            <label>Descrição</label>
                            <input type="text" name='descricao' value="{{$doc_descricao}}" class="form-control" required>
                        </div>
                        <div class="col col-md-2">
                            <label>&nbsp;</label>
                            
                            <button class="btn btn-warning btn-block" @if(!$doc_descricao) disabled @endif>Editar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
    
@endsection