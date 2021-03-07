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
				<div class="card-body">	
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
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
										<input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Enter full name" value="{{ $profile->name }}">
								
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="father_name">Father's Name: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('father_name') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-user-friends"></i></span>
										<input type="text" name="father_name" id="father_name" class="form-control @error('father_name') is-invalid @enderror" placeholder="Enter father's name" value="{{ $profile->father_name }}">
								
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
										<input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter mobile number" value="{{ $profile->phone }}">
								
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="another_phone">Another Phone: <span class="text-danger text_size"></span></label>

									@error('another_phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
										<input type="text" name="another_phone" id="another_phone" class="form-control @error('another_phone') is-invalid @enderror" placeholder="Enter another mobile number" value="{{ $profile->phone_second }}">
								
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="email">Email: </label>

									@error('email') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope-open"></i></span>
										<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email id" value="{{ $profile->email }}">
								
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="goal">Goal: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('goal') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-bullseye"></i></span>
										<input type="text" name="goal" id="goal" class="form-control @error('goal') is-invalid @enderror" placeholder="Enter goal of joining" value="{{ $profile->goal }}">
								
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="dob">Date of birth: </label>

									@error('dob') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter Date of Birth" value="{{ $profile->dob }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="marital_status">Marital status: </label>

									@error('marital_status') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-users-cog"></i></span>
										<select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror" id="marital_status">
											<option selected value="{{ $profile->marital_status }}">
												@if ($profile->marital_status == 0)
													{{"Single"}}
												@else
													{{"Married"}}
												@endif
											</option>
											@if ($profile->marital_status == 0)
												<option value="1">{{"Married"}}</option>
											@else
												<option value="0">{{"Single"}}</option>
											@endif
										</select>								
									</div>
									
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="medical_issue">Any Medical Issue: </label>

									@error('medical_issue') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-briefcase-medical"></i></span>
										<select name="medical_issue" class="form-control @error('medical_issue') is-invalid @enderror" id="medical_issue">
											<option selected value="{{ $profile->medical_issue }}">
												@if ($profile->medical_issue == 0)
													{{"No medical issue"}}
												@else
													{{"Have medical issue"}}
												@endif
											</option>
											@if ($profile->medical_issue == 0)
												<option value="1">{{"Have medical issue"}}</option>
											@else
												<option value="0">{{"No medical issue"}}</option>
											@endif
										</select>
									</div>
									
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="is_employeed">Is Employeed: </label>

									@error('is_employeed') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
										<select name="is_employeed" class="form-control @error('is_employeed') is-invalid @enderror" id="is_employeed">
											<option selected value="{{ $profile->is_employeed }}">
												@if ($profile->is_employeed == 0)
													{{"Not employeed"}}
												@else
													{{"Employeed"}}
												@endif
											</option>
											@if ($profile->is_employeed == 0)
												<option value="1">{{"Employeed"}}</option>
											@else
												<option value="0">{{"Not employeed"}}</option>
											@endif
										</select>
									</div>
									
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="place_photo_on_website">Place photo on website: </label>

									@error('place_photo_on_website') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-image"></i></span>
										<select name="place_photo_on_website" class="form-control @error('place_photo_on_website') is-invalid @enderror" id="place_photo_on_website">
											<option selected value="{{ $profile->place_photo_on_website }}">
												@if ($profile->place_photo_on_website == 0)
													{{"No"}}
												@else
													{{"Yes"}}
												@endif
											</option>
											@if ($profile->place_photo_on_website == 0)
												<option value="1">{{"Yes"}}</option>
											@else
												<option value="0">{{"No"}}</option>
											@endif
										</select>
									</div>
									
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="identity_type">Identity type: </label>

									@error('identity_type') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-portrait"></i></span>
										<input type="text" name="identity_type" id="identity_type" class="form-control @error('identity_type') is-invalid @enderror" placeholder="Enter identity type" value="{{ $profile->identity_type }}">
										
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="identity_number">Identity Number: </label>

									@error('identity_number') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card-alt"></i></span>
										<input type="text" name="identity_number" id="identity_number" class="form-control @error('identity_number') is-invalid @enderror" placeholder="Enter identity number " value="{{ $profile->identity_number }}">
									</div>
								</div>
							</div>
						</div>

						{{-- <div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="package">Package: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('package') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-box"></i></span>
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
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="fee">Fee: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('fee') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-money-bill-wave"></i></span>
										<input type="text" name="fee" id="fee" class="form-control @error('fee') is-invalid @enderror" placeholder="Enter Fee" value="{{ $profile->fee }}">
									</div>
								</div>
							</div>
						</div> --}}

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="gender">Gender: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('gender') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-venus-double"></i></span>
										<select name="gender" id="gender" class="form-control @error('email') is-invalid @enderror">
											<option selected value="{{ $profile->gender }}">{{ ucfirst($profile->gender) }}</option>
											@if ($profile->gender == "male")
												<option value="female">Female</option>
												<option value="transgender">Transgender</option>
											@elseif($profile->gender == "female")
												<option value="male">Male</option>	
												<option value="transgender">Transgender</option>
											@elseif($profile->gender == "transgender")
												<option value="male">Male</option>	
												<option value="female">Female</option>
											@endif
										</select>
									</div>
									
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="remark">Remark: </label>

									@error('remark') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-bookmark"></i></span>
										<input type="text" name="remark" id="remark" class="form-control @error('remark') is-invalid @enderror" placeholder="Enter remark" value="{{ $profile->remark }}">
								
								
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="height">Height: </label>

									@error('height') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-ruler-vertical"></i></span>
										<input type="text" name="height" id="height" class="form-control @error('height') is-invalid @enderror" placeholder="Enter Height" value="{{ $profile->height }}">
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="weight">Weight: </label>

									@error('weight') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-weight"></i></span>
										<input type="text" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="Enter Weight" value="{{ $profile->weight }}">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="customer_image">Customer Image: </label>

									@error('customer_image') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-image"></i></span>
										<input type="file" name="customer_image" id="customer_image" class="form-control @error('customer_image') is-invalid @enderror">

									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-4">
								<div class="form-group mb-3">
									<label for="state">State: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('state') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marked-alt"></i></span>
										<input type="text" name="state" id="state" placeholder="Enter State" class="form-control @error('state') is-invalid @enderror" value="{{ $profile->state }}">

									</div>
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group mb-3">
									<label for="city">City: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('city') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-city"></i></span>
										<input type="text" name="city" id="city" placeholder="Enter City" class="form-control @error('city') is-invalid @enderror" value="{{ $profile->city }}">

									</div>
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group mb-3">
									<label for="pincode">Pincode: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('pincode') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>
										<input type="text" name="pincode" placeholder="Enter Pincode" id="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ $profile->pincode }}">

									</div>
								</div>
							</div>

						</div>


						<div class="form-group mb-2">
							<label for="address">Address: <span class="text-danger text_size"><sup>*</sup></span></label>

							@error('address') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<textarea type="text" name="address" rows="3" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ $profile->address }}</textarea>
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