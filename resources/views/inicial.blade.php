@extends('commons.template')

@push('styles')
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
@endpush
@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Gerenciamento Eletronico de Documentos - {{ucfirst($setor)}}</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<a href='/documentos' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-file"></i></span>
										<p>
											<span class="number">{{$qtde_documentos}}</span>
											<span class="title">Documentos</span>
										</p>
									</div>
								</a>
								<a href='/setores' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-users"></i></span>
										<p>
											<span class="number">{{$qtde_setores}}</span>
											<span class="title">Setores</span>
										</p>
									</div>
								</a>
								<a href='/funcionarios' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-user"></i></span>
										<p>
											<span class="number">{{$qtde_funcionarios}}</span>
											<span class="title">Funcionarios</span>
										</p>
									</div>
								</a>
								<a href='/processos' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-file-text"></i></span>
										<p>
											<span class="number">{{$qtde_processos}}</span>
											<span class="title">Processos</span>
										</p>
									</div>
								</a>
								<a href='/status' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
										<p>
											<span class="number">{{$qtde_status}}</span>
											<span class="title">Status</span>
										</p>
									</div>
								</a>
								<a href='/desenho_fluxos' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-arrows-alt"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Desenho de Fluxos</span>
										</p>
									</div>
								</a>
							</div>
							
                        </div>
                    
                    
                            </div>
					<!-- END OVERVIEW -->
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
      </form>
      </div>
    </div>
  </div>
</div>

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
		  </script>
	  @endpush      
            
@endsection	
