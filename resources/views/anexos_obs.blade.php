@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')

	<div class="row">
		<div class="col col-md-6">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h4>Anexos - Documento : <span class='negrito'></span></h4>
				</div>
				<div class="panel-body">
					   <form action="/anexos" method="post" enctype="multipart/form-data">
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
					
				</div>
			</div>
		</div>

		<div class="col col-md-6">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h4>Observações - Documento : </h4>
				</div>
				<div class="panel-body">
					 <form action="/obs" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Observação</label>
                                        <textarea class='form-control' name="obs" rows="4" cols="30"
													minlength="10" maxlength="20" required></textarea>
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
					
				</div>
			</div>
		</div>
	</div>           

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
@endsection	
