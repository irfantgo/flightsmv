<!DOCTYPE html>
<html style="height: auto;" lang="en">
@include('cpanel.html-head')
<body class="hold-transition login-page" >

	<div class="login-box">
		<div class="login-logo">
			<a href="/">
				<img src="{{ assets('img/flightmv_v2.jpg') }}" style="width: 60%; margin: 30px 0;" alt="">
				<br>
				{{ env('APP_NAME') }}
			</a>
		</div>
		<!-- /.login-logo -->

		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in to start your session</p>
				<form action="/login/process" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen-server" >
					<div class="input-group mb-3">
						<input type="text" name="username" id="username" class="form-control" placeholder="Username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					{{ csrf() }}
					<div class="row">
						<div class="col-8"></div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
	
	@include('cpanel.html-footer')
		
	@include('cpanel.parts.alerts')
</body>
</html>