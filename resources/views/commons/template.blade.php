<!doctype html>
<html lang="pt-br">

<head>
	<title>GED</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/dropify/dist/css/dropify.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist-custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-dt/css/jquery.dataTables.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap4-toggle/css/bootstrap4-toggle.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link rel="stylesheet" href="{{url('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
	
     @stack('styles')
</head>
{{-- class="layout-fullwidth" --}}
<body> 
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand brand-modificado">
				<a href="/"><img src="{{asset('assets/img/logo.png')}}" alt="Klorofil Logo" class="img-responsive logo logo-modificado"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                {{-- Area de Pesquisa --}}
				{{-- <form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form> --}}
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
                        {{-- Area de Notificações --}}
						{{-- <li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li> --}}
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/img/semfotocircular.png')}}" class="img-circle" alt="Avatar"> <span>{{ $_SESSION['usuario']}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="/" @if(Route::current()->uri() == '/') class="active" @endif><i class="lnr lnr-home"></i> <span>Pagina Inicial</span></a></li>
						<li><a href="/documentos" @if(Route::current()->uri() == 'documentos/{mostrar_finalizado?}/{mostrar_outros_setores?}') class="active" @endif><i class="fa fa-file"></i> <span>Documentos</span></a></li>
						@if($_SESSION['is_admin'])
						<li><a href="/setores" @if(Route::current()->uri() == 'setores') class="active" @endif><i class="fa fa-users"></i> <span>Setores</span></a></li>
						<li><a href="/funcionarios" @if(Route::current()->uri() == 'funcionarios') class="active" @endif><i class="fa fa-user"></i> <span>Funcionarios</span></a></li>
						<li><a href="/processos" @if(Route::current()->uri() == 'processos') class="active" @endif><i class="fa fa-file-text"></i> <span>Processos</span></a></li>
						@endif
						<li><a href="/status" @if(Route::current()->uri() == 'status') class="active" @endif><i class="fa fa-exclamation-triangle"></i> <span>Status</span></a></li>
						@if($_SESSION['is_admin'])
						<li><a href="/desenho_fluxos" @if(Route::current()->uri() == 'desenho_fluxos') class="active" @endif><i class="fa fa-arrows-alt"></i> <span>Desenho de Fluxos</span></a></li>
						@endif
						
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					
					@yield('conteudo')
                
                </div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{url('assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{url('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('assets/vendor/dropify/dist/js/dropify.min.js')}}"></script>
	<script src="{{url('assets/vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
	<script src="{{url('assets/vendor/bootstrap4-toggle/js/bootstrap4-toggle.min.js')}}"></script>
	<script src="{{url('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{url('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<script src="{{url('assets/vendor/chartist/js/chartist.min.js')}}"></script>
	<script src="{{url('assets/scripts/klorofil-common.js')}}"></script>

	<script src="{{url('assets/vendor/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

	
    
     @stack('scripts')
</body>

</html>
