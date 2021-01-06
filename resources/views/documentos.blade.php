@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')

    <div class="row">
        
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Upload de Arquivos</h5>
                                </div>
                                <div class="card-block">
                                    <form action="#" class="dropzone dz-clickable">
                                        <div>
                                            <label for="file">Documento</label>
                                            <input type="file" id="file" name="file" multiple>
                                        </div>
                                    </form>
                                    <div class="text-center m-t-10">
                                        <button class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($lista_arquivos)
                    <h4>Arquivos no Setor de {{ucfirst($setor)}}</h4>
                    <table class="table table-striped menor">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th>Set.Anterior</th>
                                <th>Set.Atual</th>
                                <th class='center'>Arquivo</th>
                                <th class='center'>Processo</th>
                                <th class='center'>Status</th>
                                <th class='center'>Img</th>
                                <th class='center'>Seguir Fluxo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista_arquivos as $item)
                            <tr>
                                <td>
                                    {{$item->descricao }}
                                </td>
                                <td>{{ $item->setor_anterior }}</td>
                                <td>{{ $item->setor_atual }}</td>
                                <td class='menor'>{{$item->caminho}}</td>
                                <td>{{$item->descricao_processo}}</td>
                                <td>{!! $item->status !!}</td>
                                <td>
                                    <center><button 
                                        data-toggle="modal" 
                                        data-target="#modalImg" 
                                        onclick="mostrarModalImg(event)"
                                        data-item-id={{$item->id}}
                                        data-item-img='{{$item->processos_img}}'
                                        class="btn btn-sm btn-info"><i class="fa fa-file-image-o"></i></button></center>
                                </td>
                                <form action="/seguir_fluxo" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="caminho" value="{{$item->caminho}}">
                                        <input type="hidden" name="arquivo" value="{{$item->descricao}}">
                                        <input type="hidden" name="setor_atual_id" value="{{$item->setor_atual_id}}"> 
                                        <input type="hidden" name="passo_processo_id" value="{{$item->passo_processo_id}}">
                                        <input type="hidden" name="processo_id" value="{{$item->processo_id}}">
        
                                <td><center><button class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></button></center></td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br><br><br>
                    @endif
                    @if($lista_arquivos_geral)
                    <h4>Arquivos sem processo atribuido</h4>
                    <table class="table table-striped menor">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th class='center'>Arquivo</th>
                                <th class='center'>Selecionar</th>
                                <th class='center'>Status</th>
                                <th class='center'>Iniciar Fluxo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista_arquivos_geral as $item)
                            <tr>
                                <td>
                                    {{$item->descricao}}
                                </td>
                                <td class='menor'>{{$item->caminho}}</td>
                                <td>
                                <form action="/seguir_fluxo" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="caminho" value="{{$item->caminho}}">
                                        <input type="hidden" name="arquivo" value="{{$item->descricao}}">
                                        <input type="hidden" name="passo_processo_id" value="0">
                
            
                                    <select name="processo_id" required class="form-control">
                                        <option></option>
                                        @foreach ($processos as $processo)
                                            <option value="{{$processo->id}}">{{$processo->descricao}}</option>
                                        @endforeach
                                    </select></td>
                                <td>{!! $item->status !!}</td>
                                <td><center><button class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></button></center></td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br><br>
                    @endif
                </div>
            </div>
@endsection