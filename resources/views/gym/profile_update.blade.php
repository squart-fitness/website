@extends('parent')

@section('content')
	<div class="content">
		<div class="animated fadeIn">
			@if (Session::has('msg'))
				<div class="alert alert-primary">
				   {!! Session::get('msg') !!}			
				</div>
			@endif

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>UPDATE PROFILE</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_gym') }}">GYM</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Update gym</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">	
					<form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="name">Name:</label>

									@error('name') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter GYM name" value="{{ $profile->name }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone:</label>

									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter GYM mobile number" value="{{ $profile->phone }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="email">Email:</label>

									@error('email') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter GYM email id" value="{{ $profile->email }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="profile_image">Profile Image: </label>

									@error('profile_image') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Save</button>
						</div>
					</form>					
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<span>CHANGE PASSWORD</span>
				</div>
				<div class="card-body">	
					<form action="{{ route('update_password') }}" method="post">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="old_password">Old password:</label>

									@error('old_password') 
									    <div class="alert alert-danger" style="padding: 0; font-size: 12px;">{{ $message }}</div>
									@enderror
									<input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter old password">
								</div>
								<div class="form-group mb-3">
									<label for="new_password">New password:</label>

									@error('new_password') 
									    <div class="alert alert-danger" style="padding: 0; font-size: 12px;">{{ $message }}</div>
									@enderror
									<input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password">
								</div>
								<div class="form-group mb-3">
									<label for="confirm_password">Confirm password:</label>

									@error('confirm_password') 
									    <div class="alert alert-danger" style="padding: 0; font-size: 12px;">{{ $message }}</div>
									@enderror
									<input type="password" name="new_password_confirmation" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Re-enter password">
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_4">Change</button>
						</div>
					</form>					
				</div>
			</div>

		</div>
	</div>

@endsection