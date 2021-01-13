@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')

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
                                        <input type='text' name="descricao" class='form-control' required>
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
                                        <textarea class='form-control' name="descricao" rows="4" cols="30" required></textarea>
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
												<td class='justificado'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$item->descricao}}</td>
												<td>{{$item->usuario}}</td>
												<td></td>
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

	@push('scripts')
		<script>
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
