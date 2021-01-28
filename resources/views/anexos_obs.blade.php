@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')
	<div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Historico de Movimentações</h3>
                    <h4><span class='negrito'>Documento: {{$doc_descricao}}</span></h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped myTable">
										<thead>
											<tr>
                        <th>Data e Hora</th>
                        <th class='center'>De</th>
						<th class='center'>Para</th>
						<th class='center'>Escolha</th>
                        <th class='center'>Usuario</th>
                        <th class='center'>IP</th>
                        <th class='center'>Processo</th>
                      </tr>
										</thead>
										<tbody>
											@foreach ($hist_mov as $item)
											<tr>
                          <td>{{$item->systemdate }}</td>
                          <td class='center'>{{$item->nome_de }}</td>
						  <td class='center'>{{$item->nome_para }}</td>
						  <td class='center'>{{$item->nome_seta }}</td>
                          <td class='center'>{{$item->rotulo }}</td>
                          <td class='center'>{{$item->ip }}</td>
                          <td class='center'>{{$item->proceso_descricao }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col col-md-6">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h4>Anexos - Documento : <span class='negrito'>{{ $documentos[0]->descricao ?? null}}</span></h4>
				</div>
				<div class="panel-body">
					   <form action="/anexos" method="post" enctype="multipart/form-data">
						  <input type="hidden" name='documento_id' value='{{$documento_id}}'>
                            @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Documento</label>
                                        <input type='file' name="documento"  class="dropify" data-height="80" required>
                                    </div>
                                    <div class="col-md-9">
                                        <label>Descrição</label>
                                        <input type='text' name="descricao" class='form-control' required autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button class='btn btn-block btn-primary'>Enviar</button>
                                    </div>
                                </div>
							</form>
							@if ($anexos)
							<br>
							<table class="table table-striped menor myTable">
                                        <thead>
                                            <tr>
												<th>Descrição</th>
												 <th>Usuario</th>
                                                <th class='center'>Arquivo</th>
												<th class='center'>Apagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@foreach ($anexos as $item)
												
											<tr>
												<td>{{$item->descricao}}</td>
												<td>{{$item->usuario}}</td>
												<td><center><a target='_blank' href='{{$item->caminho}}' class="btn btn-sm btn-success"><i class="fa fa-file"></i></a></center> </td>
												 <td>
													@if ($item->usuario_id == $_SESSION['id'])
														<form action="/anexos" method="post">
															@csrf
															@method('delete')
															<input type="hidden" name="id" value={{$item->id}}>
															
															<center><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
														</form>
													@else
														<center><button disabled class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
												  	@endif
                                                </td>
											</tr>
											@endforeach
										</tbody>
							</table>
							@endif
				</div>
			</div>
		</div>

		<div class="col col-md-6">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h4>Observações - Documento : <span class='negrito'>{{ $documentos[0]->descricao ?? null}}</span></h4>
				</div>
				<div class="panel-body">
					 <form action="/obs" method="post" enctype="multipart/form-data">
							<input type="hidden" name='documento_id' value='{{$documento_id}}'>
                            @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Observação</label>
                                        <textarea class='form-control' name="descricao" rows="4" cols="30" required autocomplete="off"></textarea>
                                    </div>
									<div class="col-md-9"></div>
									<div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <button class='btn btn-block btn-primary'>Enviar</button>
                                    </div>
                                </div>
							</form>
							
							@if ($obs)
							<br>
							<table class="table table-striped menor myTable">
                                        <thead>
                                            <tr>
												<th>Descrição</th>
												<th>Usuario</th>
                                                <th class='center'>Editar</th>
												<th class='center'>Apagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@foreach ($obs as $item)
												
											<tr>
												<td class='justificado'>{{$item->descricao}}</td>
												<td>{{$item->usuario}}</td>
												<td>
													@if ($item->usuario_id == $_SESSION['id'])
													<center><button 
                                                        data-toggle="modal" 
                                                        data-target="#modalEditar" 
                                                        onclick="mostrarModal(event)"
                                                        data-item-id={{$item->id}}
                                                        data-item-descricao='{{$item->descricao}}'
														class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></center>
													@else	
													<center><button disabled class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></center>
													@endif
												</td>
												 <td>
													@if ($item->usuario_id == $_SESSION['id'])
													<form action="/obs" method="post">
														@csrf
														@method('delete')
														<input type="hidden" name="id" value={{$item->id}}>
														
														<center><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
													</form>
													@else
														<center><button disabled class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
													@endif
                                                </td>
											</tr>
											@endforeach
										</tbody>
							</table>
							@endif
					
				</div>
			</div>
		</div>
	</div>           
 <!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/obs" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-12">
				  <label>Descrição</label>
				  <textarea class='form-control'  id='item-descricao' name="descricao" rows="4" cols="30" required autocomplete="off"></textarea>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Editar</button>
      </form>
      </div>
    </div>
  </div>
</div>

	@push('scripts')
		<script>
			function mostrarModal(event) {
                const button = event.currentTarget
                const descricao = document.querySelector("#modalEditar #item-descricao")
                const id = document.querySelector("#modalEditar #item-id")

                descricao.innerHTML = button.getAttribute("data-item-descricao")
                id.value = button.getAttribute("data-item-id")
            }
			   $(document).ready( function () {
                    $('.myTable').DataTable();
                } );
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
@endsection	
