@extends('commons.template')

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
								@if($_SESSION['is_admin'])
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
								@endif
								<a href='/status' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
										<p>
											<span class="number">{{$qtde_status}}</span>
											<span class="title">Status</span>
										</p>
									</div>
								</a>
								@if($_SESSION['is_admin'])
								<a href='/desenho_fluxos' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-arrows-alt"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Desenho de Fluxos</span>
										</p>
									</div>
								</a>
								@endif
							</div>
							
                        </div>
                    
                    
                            </div>
					<!-- END OVERVIEW -->
	

       
            
@endsection	
