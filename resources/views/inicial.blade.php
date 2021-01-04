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
                    
					<div class="row">
						<div class="col-md-4">
							<!-- TASKS -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Documentos</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled task-list">
										<li>
											<p>Updating Users Settings <span class="label-percent">23%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width:23%">
													<span class="sr-only">23% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Load &amp; Stress Test <span class="label-percent">80%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
													<span class="sr-only">80% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Data Duplication Check <span class="label-percent">100%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span class="sr-only">Success</span>
												</div>
											</div>
										</li>
										<li>
											<p>Server Check <span class="label-percent">45%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
													<span class="sr-only">45% Complete</span>
												</div>
											</div>
										</li>
										<li>
											<p>Mobile App Development <span class="label-percent">10%</span></p>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
													<span class="sr-only">10% Complete</span>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<!-- END TASKS -->
						</div>
						<div class="col-md-4">
							<!-- VISIT CHART -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Website Visits</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div id="visits-chart" class="ct-chart"></div>
								</div>
							</div>
							<!-- END VISIT CHART -->
						</div>
						<div class="col-md-4">
							<!-- REALTIME CHART -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">System Load</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div id="system-load" class="easy-pie-chart" data-percent="70">
										<span class="percent">70</span>
									</div>
									<h4>CPU Load</h4>
									<ul class="list-unstyled list-justify">
										<li>High: <span>95%</span></li>
										<li>Average: <span>87%</span></li>
										<li>Low: <span>20%</span></li>
										<li>Threads: <span>996</span></li>
										<li>Processes: <span>259</span></li>
									</ul>
								</div>
							</div>
							<!-- END REALTIME CHART -->
						</div>
					</div>
            
            
@endsection	

@push('scripts')
    <script>
        $(function() {
            var data, options;

            // headline charts
            data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    [23, 29, 24, 40, 25, 24, 35],
                    [14, 25, 18, 34, 29, 38, 44],
                ]
            };

            options = {
                height: 300,
                showArea: true,
                showLine: false,
                showPoint: false,
                fullWidth: true,
                axisX: {
                    showGrid: false
                },
                lineSmooth: false,
            };

            new Chartist.Line('#headline-chart', data, options);


            // visits trend charts
            data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [{
                    name: 'series-real',
                    data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
                }, {
                    name: 'series-projection',
                    data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
                }]
            };

            options = {
                fullWidth: true,
                lineSmooth: false,
                height: "270px",
                low: 0,
                high: 'auto',
                series: {
                    'series-projection': {
                        showArea: true,
                        showPoint: false,
                        showLine: false
                    },
                },
                axisX: {
                    showGrid: false,

                },
                axisY: {
                    showGrid: false,
                    onlyInteger: true,
                    offset: 0,
                },
                chartPadding: {
                    left: 20,
                    right: 20
                }
            };

            new Chartist.Line('#visits-trends-chart', data, options);


            // visits chart
            data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    [6384, 6342, 5437, 2764, 3958, 5068, 7654]
                ]
            };

            options = {
                height: 300,
                axisX: {
                    showGrid: false
                },
            };

            new Chartist.Bar('#visits-chart', data, options);


            // real-time pie chart
            var sysLoad = $('#system-load').easyPieChart({
                size: 130,
                barColor: function(percent) {
                    return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
                },
                trackColor: 'rgba(245, 245, 245, 0.8)',
                scaleColor: false,
                lineWidth: 5,
                lineCap: "square",
                animate: 800
            });

            var updateInterval = 3000; // in milliseconds

            setInterval(function() {
                var randomVal;
                randomVal = getRandomInt(0, 100);

                sysLoad.data('easyPieChart').update(randomVal);
                sysLoad.find('.percent').text(randomVal);
            }, updateInterval);

            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

        });
        </script>
                
@endpush