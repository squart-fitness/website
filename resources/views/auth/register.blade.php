@extends('out-master')

@section('stylesheet')
	<link href="{{asset('assets/libraries/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" media="all">
	<link href="{{asset('assets/css/register_style.css')}}" rel="stylesheet" type="text/css" media="all"/>
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900" rel="stylesheet">

	<style>
		.agile_info{
			margin-top: 30px;
		}
		@media(max-width: 992px){
			.agile_info{
				margin-top: 80px;
			}
		}
	</style>
@endsection

@section('content')

<div class="signupform">
	{{-- <h1>Squart Register Form</h1> --}}
	<div class="container">
		
		<div class="agile_info">
			<div class="w3l_form">
				<div class="left_grid_info">
					<h3>Register in Squart</h3>
					<p>
						Our Gym Management Software is updated with the latest technology and online services.   
					</p>
					{{-- <p> Nam eleifend velit eget dolor vestibulum ornare. Vestibulum est nulla, fermentum eget euismod et, tincidunt at dui. Nulla tellus nisl, semper id justo vel, rutrum finibus risus. Cras vel auctor odio.</p> --}}
					<img src="{{ asset('/assets/img/fitness-group.png') }}" alt="fitness-group">
				</div>
			</div>
			<div class="w3_info">
				<h2>Create An Account</h2>
				{{-- <p></p> --}}
					<form action="{{ route('register') }}" method="post">
						@csrf

						@error('name') 
						    <div class="alert alert-danger" style="padding: 0; font-size: 14px;">{{ $message }}</div>
						@enderror 
						<div class="input-group">
							<span><i class="fa fa-user" aria-hidden="true"></i></span>
							<input type="text" name="name" placeholder="Name" required="" class="@error('name') is-invalid @enderror"> 
						</div>

						@error('phone') 
						    <div class="alert alert-danger" style="padding: 0; font-size: 14px;">{{ $message }}</div>
						@enderror
						<div class="input-group">
							<span><i class="fa fa-user" aria-hidden="true"></i></span>
							<input type="text" name="phone" placeholder="Phone number" required="" class="@error('phone') is-invalid @enderror"> 
						</div>

						@error('email') 
						    <div class="alert alert-danger" style="padding: 0; font-size: 14px;">{{ $message }}</div>
						@enderror
						<div class="input-group">
							<span><i class="fa fa-envelope" aria-hidden="true"></i></span>
							<input type="email" name="email" placeholder="Email" required="" class="@error('email') is-invalid @enderror"> 
						</div>

						@error('password') 
						    <div class="alert alert-danger" style="padding: 0; font-size: 14px;">{{ $message }}</div>
						@enderror
						<div class="input-group">
							<span><i class="fa fa-lock" aria-hidden="true"></i></span>
							<input type="Password" name="password" placeholder="Password" required="" class="@error('password') is-invalid @enderror">
						</div>

						@error('password_confirmation') 
						    <div class="alert alert-danger" style="padding: 0; font-size: 14px;">{{ $message }}</div>
						@enderror
						<div class="input-group">
							<span><i class="fa fa-lock" aria-hidden="true"></i></span>
							<input type="Password" name="password_confirmation" placeholder="Confirm Password" required="" class="@error('password_confirmation') is-invalid @enderror">
						</div>
							{{-- <input type="checkbox" value="remember-me" name="remember" /> <h4>Send me latest updates </h4>         --}}
							<button class="btn btn-danger btn-block" type="submit">Create Account</button >                
					</form>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
@endsection