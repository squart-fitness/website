@extends('parent')

@section('stylesheet')
	<style>
		.list-group-item{
			font-size: 14px;
		}
	</style>

@endsection

@section('content')

	@if (Session::has('msg'))
		<div class="alert alert-primary">
		   {!! Session::get('msg') !!}			
		</div>
	@endif

	<div class="content">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>My Profile</span>
						</div>
						<div class="float_item">
							<a href="{{ route('update_profile') }}"><button class="btn btn-sm btn-secondary">Edit</button></a>
						</div>
					</div>
				</div>
				<div class="card-body">	
					
					<div class="row">
						<div class="col-12 col-md-6">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Name: <span class="text-secondary">{{ ucfirst(auth()->user()->name) }}</span></li>
								<li class="list-group-item">Username: <span class="text-secondary">{{ auth()->user()->username }}</span></li>
								<li class="list-group-item">Phone Number: <span class="text-secondary">{{ auth()->user()->phone }}</span></li>
								<li class="list-group-item">Email: <span class="text-secondary">{{ auth()->user()->email }}</span></li>
								<li class="list-group-item">Role: <span class="text-secondary">{{ ucfirst(auth()->user()->role) }}</span></li>
								<li class="list-group-item">Join date: <span class="text-secondary">{{ auth()->user()->created_at }}</span></li>

							</ul>
						</div>
					</div>

				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>GYM Details</span>
						</div>
						<div class="float_item">
							<a href="{{ route('update_gym') }}"><button class="btn btn-sm btn-secondary">Edit</button></a>
						</div>
					</div>
				</div>
				<div class="card-body">	
					
					<div class="row">
						<div class="col-12 col-md-6">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Gym Name: <span class="text-secondary">{{ ucfirst($gymDetails->gym_name) }}</span></li>
								<li class="list-group-item">Gym Phone Number: <span class="text-secondary">{{ $gymDetails->gym_phone }}</span></li>
								<li class="list-group-item">Gym Email: <span class="text-secondary">{{ $gymDetails->gym_email }}</span></li>
								<li class="list-group-item">Personal Adhaar Number: <span class="text-secondary">{{ $gymDetails->personal_adhaar }}</span></li>
								<li class="list-group-item">Gym Address: <span class="text-secondary">{{ ucfirst($gymDetails->gym_address) }}</span></li>

								<li class="list-group-item">
									<div class="d-flex justify-content-between">
										<div class="items">
											Gym Address: <span class="text-secondary">{{ $gymDetails->status == 1 ? 'Active' : 'Deactivated' }}</span>	
										</div>
									</div>
								</li>

							</ul>
						</div>
					</div>

				</div>
			</div>

			<!-- feedback to squart -->
			<div class="card">
				<div class="card-header">
					<span>Give feedback to squart</span>
				</div>
				<div class="card-body">	
					
					<div class="row">
						<div class="col-12 col-md-6">
							<form action="{{ route('feedback') }}" method="post" accept-charset="utf-8">
								@csrf
								
								<div class="form-group">
									<label for="title">Title: <span class="text-danger"><sup>*</sup></span></label>

									@error('title') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Give Title...">
								</div>
								<div class="form-group">
									<label for="feedback">Feedback: <span class="text-danger"><sup>*</sup></span></label>

									@error('feedback') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<textarea name="feedback" rows="4" class="form-control @error('feedback') is-invalid @enderror"></textarea>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

@endsection