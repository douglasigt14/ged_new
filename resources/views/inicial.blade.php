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
									<h4>Arquivos no Setor de {{ucfirst($setor)}}</h4>
                                    <table class="table table-striped menor">
										<thead>
											<tr>
												<th>Arquivo</th>
												<th>Set.Anterior</th>
												<th>Set.Atual</th>
												<th class='center'>Arquivo</th>
												<th class='center'>Processo</th>
												<th class='center'>Img</th>
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
												<td>{{ $item->setor_anterior }}</td>
												<td>{{ $item->setor_atual }}</td>
												<td class='menor'>{{$item->caminho}}</td>
												<td>{{$item->descricao_processo}}</td>
												<td>
													<center><button 
														data-toggle="modal" 
														data-target="#modalImg" 
														onclick="mostrarModalImg(event)"
														data-item-id={{$item->id}}
														data-item-img='{{$item->processos_img}}'
														class="btn btn-sm btn-info"><i class="fa fa-file-image-o"></i></button></center>
												</td>
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
