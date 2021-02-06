@extends('parent')

@section('script_down')

	<script>
		jQuery(document).ready(function(){
			var $ = jQuery;
			var packName;
			$('#package').on('click keyup',function(){
				packName = $('#package option:selected').val();
				ajaxCall('{{ route("package_fee") }}', packName);
			});

		});

		function ajaxCall(u, d){
			var $ = jQuery;
			$.ajax({
				method: 'GET',
				url: u,
				data: {name: d},
				success:function(data){
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
					<span>UPDATE CUSTOMER</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_customer') }}">Customer</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('customer_list') }}">Customer list</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Update customer</li>
		  				</ol>
					</nav>
				</div>
			</div>
			
			<div class="card">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="align-self-center">
							<span>UPDATE CUSTOMER</span>
						</div>
						<div class="float-right">
							<a href="{{ route('add_customer') }}" class="btn btn-secondary btn-sm">Add Customer</a>
							<a href="{{ route('customer_list') }}" class="btn btn-info btn-sm">Customer List</a>
						</div>
					</div>
				</div> --}}
				<div class="card-body">	
					{{ $profile }}
					<form action="{{ route('update_customer') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="d" value="{{ $profile->id }}">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="fullname">Name: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('fullname') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Enter full name" value="{{ $profile->name }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter mobile number" value="{{ $profile->phone }}">
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
									<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email id" value="{{ $profile->email }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="goal">Goal: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('goal') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="goal" id="goal" class="form-control @error('goal') is-invalid @enderror" placeholder="Enter goal of joining" value="{{ $profile->goal }}">
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
										<option selected value="{{ $profile->package }}">{{ ucfirst($profile->package) }}</option>
										@foreach ($packageNames as $element)
											@if ($element->package_name == $profile->package)
												@continue
											@endif
											<option value="{{ $element->package_name }}">{{ ucfirst($element->package_name) }}</option>
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
									<input type="number" name="fee" id="fee" class="form-control @error('fee') is-invalid @enderror" placeholder="Enter Fee" value="{{ $profile->fee }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="dob">Date of birth:</label>

									@error('dob') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="dob" id="dob" onfocus="(this.type='date')" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter Date of Birth" value="{{ $profile->dob }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gender">Gender: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('gender') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="gender" class="form-control @error('email') is-invalid @enderror">
										<option selected value="{{ $profile->gender }}">{{ ucfirst($profile->gender) }}</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="transgender">Transgender</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="remark">Remark:</label>

									@error('remark') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="remark" id="remark" class="form-control @error('remark') is-invalid @enderror" placeholder="Enter remark" value="{{ $profile->remark }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="customer_image">Customer Image: </label>

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
							<textarea type="text" rows="3" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ $profile->address }}</textarea>
						</div>				
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_4">update</button>
						</div>
					</form>


					
				</div>
			</div>
		</div>
	</div>

@endsection