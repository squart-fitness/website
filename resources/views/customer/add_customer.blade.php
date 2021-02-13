@extends('parent')

@section('script_down')

	<script>
		jQuery(document).ready(function(){
			var $ = jQuery;

			@if (isset($profile))
				$('#fullname').val('{{ $profile->customer_name }}');
				$('#phone').val('{{ $profile->customer_phone }}');
				$('#goal').val('{{ $profile->goal }}');
				$('#gender').val('{{ $profile->gender }}');
				@isset ($profile->customer_address)
					$('#address').val('{{ $profile->customer_address }}');				    
				@endisset

				@isset ($profile->height)
				    $('#height').val('{{ $profile->height }}');
				@endisset

				@isset ($profile->weight)
				    $('#weight').val('{{ $profile->weight }}');
				@endisset

				@isset (Request::all()['eid'])
				    $('#h_field').val('{{ Request::all()['eid'] }}');
				@endisset
			@endif
		});

		jQuery(document).on('change focus', function(){
			var $ = jQuery;
			var packID = $('#package option:selected').val();
			ajaxCall('{{ route("package_fee") }}', packID);
		});

		function ajaxCall(u, d){
			var $ = jQuery;
			$.ajax({
				method: 'GET',
				url: u,
				data: {pid: d},
				success:function(data){
					console.log(data);
					$('#fee').val(data.fee);
				}
			});
		}
	</script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">
			@if(Session::has('msg'))
				<div class="alert alert-success">
					{!! Session::get('msg') !!}
				</div>
			@endif

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>ADD MEMBER</span>
					<a href="{{ route('customer_list') }}" class="btn btn-secondary btn-sm ml-3">Member list</a>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Add Member</li>
		  				</ol>
					</nav>
				</div>
			</div>
			
			<div class="card">
				<div class="card-body">	
					<form action="{{ route('add_customer') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf

						<input type="hidden" name="eid" id="h_field">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="fullname">Name: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('fullname') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Enter full name" value="{{ old('fullname') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter mobile number" value="{{ old('phone') }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="email">Email: (Optional)</label>

									@error('email') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email id" value="{{ old('email') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="goal">Goal: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('goal') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="goal" id="goal" class="form-control @error('goal') is-invalid @enderror" placeholder="Enter goal of joining" value="{{ old('goal') }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="dob">Date of birth: (Optional)</label>

									@error('dob') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter Date of Birth" value="{{ old('dob') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="password">Password: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('password') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" value="{{ old('password') }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="package">Package: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('package') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="package" class="form-control @error('package') is-invalid @enderror" id="package">
										<option selected disabled>Select package</option>
										@foreach ($packageNames as $element)
											<option value="{{ $element->id }}">{{ ucfirst($element->package_name) }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="fee">Fee: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('fee') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="fee" id="fee" class="form-control @error('fee') is-invalid @enderror" placeholder="Enter Fee" value="{{ old('fee') }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gender">Gender: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('gender') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="gender" id="gender" class="form-control @error('email') is-invalid @enderror">
										<option selected disabled>Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="transgender">Transgender</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="remark">Remark: (Optional)</label>

									@error('remark') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="remark" id="remark" class="form-control @error('remark') is-invalid @enderror" placeholder="Enter remark" value="{{ old('remark') }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="height">Height: (Optional)</label>

									@error('height') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="height" id="height" class="form-control @error('height') is-invalid @enderror" placeholder="Enter Height" value="{{ old('height') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="weight">Weight: (Optional)</label>

									@error('weight') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="Enter Weight" value="{{ old('weight') }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="batch">Batch: (Optional)</label>

									@error('batch') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="batch" class="form-control @error('batch') is-invalid @enderror" id="batch">
										<option selected value="">Select batch</option>
										@foreach ($batches as $element)
											<option value="{{ $element->name }}">{{ ucfirst($element->name) }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="customer_image">Customer Image: (Optional)</label>

									@error('customer_image') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="file" name="customer_image" id="customer_image" class="form-control @error('customer_image') is-invalid @enderror">
								</div>
							</div>
						</div>

						<div class="form-group mb-2">
							<label for="address">Address: <span class="text-danger text_size"><sup>*</sup></span></label>

							@error('address') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<textarea type="text" name="address" rows="3" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ old('address') }}</textarea>
						</div>				
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_4">Save</button>
						</div>
					</form>


					
				</div>
			</div>
		</div>
	</div>

@endsection