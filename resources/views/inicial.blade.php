@extends('commons.template')


@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Gerenciamento Eletronico de Documentos - {{ucfirst($setor)}}</h3>
						</div>
						<div class="panel-body">
							<div class="row">
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
                            <div class="row">
                                <div class="col-md-12">
									@if($lista_arquivos)
									<h3>Arquivos no Setor de {{ucfirst($setor)}}</h3>
                                    <table class="table table-striped">
										<thead>
											<tr>
												<th>Arquivo</th>
												<th>Setor Anterior</th>
												<th>Setor Atual</th>
												<th class='center'>Caminho</th>
												<th class='center'>Status</th>
												<th class='center'>Seguir Fluxo</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($lista_arquivos as $item)
											<tr>
											    <td>
													{{$item->descricao }}
												</td>
												<td>{{ $item->setor_anterior_id }}</td>
												<td>{{ $item->setor_atual_id }}</td>
												<td>{{ $item->caminho }}</td>
												<td>{!! $item->status !!}</td>
												<form action="/seguir_fluxo" method="post">
                             						 @csrf
													  <input type="hidden" name="id" value="{{$item->id}}">
													  <input type="hidden" name="caminho" value="{{$item->caminho}}">
													  <input type="hidden" name="arquivo" value="{{$item->descricao}}">
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
									<h3>Arquivos sem processo atribuido</h3>
                                    <table class="table table-striped">
										<thead>
											<tr>
												<th>Arquivo</th>
												<th class='center'>Caminho</th>
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
												<td>{{$item->caminho}}</td>
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
                        </div>
                    
                    
                            </div>
                    <!-- END OVERVIEW -->
            
            
@endsection	
