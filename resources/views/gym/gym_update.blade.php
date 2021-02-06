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
					<span>UPDATE GYM</span>
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
				{{-- <div class="card-header">
					UPDATE GYM
				</div> --}}
				<div class="card-body">	
					<form action="{{ route('update_gym') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gymname">GYM Name:</label>

									@error('gymname') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="gymname" id="gymname" class="form-control @error('gymname') is-invalid @enderror" placeholder="Enter GYM name" value="{{ $gymdata->gym_name }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gymphone">GYM Phone:</label>

									@error('gymphone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="number" name="gymphone" id="gymphone" class="form-control @error('gymphone') is-invalid @enderror" placeholder="Enter GYM mobile number" value="{{ $gymdata->gym_phone }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gymemail">GYM Email:</label>

									@error('gymemail') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="email" name="gymemail" id="gymemail" class="form-control @error('gymemail') is-invalid @enderror" placeholder="Enter GYM email id" value="{{ $gymdata->gym_email }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gym_logo">GYM Logo: </label>

									@error('gym_logo') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="file" name="gym_logo" id="gym_logo" class="form-control @error('gym_logo') is-invalid @enderror">
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group mb-2">
							<label for="address">Address:</label>

							@error('address') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<textarea type="text" rows="4" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ $gymdata->gym_address }}</textarea>
						</div>				
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Save</button>
						</div>
					</form>


					
				</div>
			</div>
		</div>
	</div>

@endsection