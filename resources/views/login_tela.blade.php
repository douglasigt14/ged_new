
<!DOCTYPE html>
<html>
<head>
	<title>GED</title>
   <!--Made with love by Mutiullah Samim -->
   
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/login.css')}}">

	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/bootstrap-4.1.3/css/bootstrap.min.css')}}">

	{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
</head>
<body>
    @if (Session::has('login_erro'))
                <p class="bg-alert">{{Session::get('login_erro')}}</p>
              @endif
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>GED</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/login')}}" method="POST">
                @csrf
					<div class="input-group form-group">
						<input  autocorrect="off" autocapitalize="off" spellcheck="false" name='name'  type="text" class="form-control" placeholder="login">
						
					</div>
					<div class="input-group form-group">
						<input name='password'  type="password" class="form-control" placeholder="senha">
					</div>
					<div class="form-group">
						<input type="submit" value="Login" class="btn btn-lg btn-info btn-block">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>