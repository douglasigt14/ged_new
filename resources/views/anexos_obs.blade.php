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
					
					
				</div>
			</div>
		</div>

		<div class="col col-md-6">
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h4>Observações - Documento : </h4>
				</div>
				<div class="panel-body">
					
					
				</div>
			</div>
		</div>
	</div>           
@endsection	
