@extends('parent')

@section('stylesheet')
	
	<style type="text/css">
		@media(max-width: 768px){
			.content{
				padding-left: 5px;
				padding-right: 5px;
			}
		}

	</style>

@endsection

@section('content')
	<div class="content">
		<div class="animated fadedIn">
			@if (Session::has('is_save'))
				<div class="alert alert-success">
					{!! Session::get('is_save') !!}			
				</div>
			@endif

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>ENQUIRY</span>
					<a href="{{ route('showall_enquiry') }}" class="btn btn-secondary btn-sm ml-3">Enquiry Details</a>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">
		  				<ol class="breadcrumb">
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Enquiry</li>
		  				</ol>
					</nav>
				</div>
			</div>
			<div class="card">
				{{-- <div class="card-header">
					Enquiry
				</div> --}}
				<div class="card-body">	
					<form action="{{ route('add_enquiry') }}" method="post" accept-charset="utf-8">
						@csrf
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
								<div class="form-group mb-2">
									<label for="gender">Gender: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('gender') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="gender" class="form-control" id="gender">
										<option selected disabled>Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="transgender">Transgender</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="soe">Source of Enquiry: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('soe') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="soe" id="soe" class="form-control @error('soe') is-invalid @enderror" placeholder="Enter Source of Enquiry" value="{{ old('soe') }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="goal">Goal: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('goal') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="goal" class="form-control" id="goal">
										<option value="weight loss">Weight Loss</option>
										<option value="weight gain">Weight Gain</option>
										<option value="body building">Body Building</option>
										<option value="fitness">Fitness</option>
										<option value="general training">General Training</option>
									</select>
									{{-- <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" placeholder="Enter enquired for" value="{{ old('type') }}"> --}}
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="plan_interested">Package Interested: (Optional)</label>

									@error('plan_interested') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="plan_interested" class="form-control" id="plan_interested">
										<option selected disabled>Select Package</option>
										@foreach ($packages as $element)
											<option value="{{$element->package_name}}">{{$element->package_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group mb-2">
							<label for="address">Address: (Optional)</label>

							@error('address') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<textarea type="text" name="address" rows="3" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ old('address') }}</textarea>
						</div>		
						<hr>

						<h4 class="pt-3 pb-3 mb-4 mt-2 pl-2 bg-light shadow-sm">Additional Information</h4>

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
								<div class="form-group mb-2">
									<label for="follow_up_date">Follow Up Date: (Optional)</label>

									@error('follow_up_date') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="follow_up_date" id="follow_up_date" class="form-control @error('follow_up_date') is-invalid @enderror" placeholder="Enter Follow Up Date" value="{{ old('follow_up_date') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="trail_date">Trail Date: (Optional)</label>

									@error('trail_date') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="trail_date" id="trail_date" class="form-control @error('trail_date') is-invalid @enderror" placeholder="Enter Follow Up Date" value="{{ old('trail_date') }}">
								</div>
							</div>
						</div>		
						
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="response">Response: (Optional)</label>

									@error('response') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="response" id="response" class="form-control">
										<option selected disabled>Select Customer Response</option>
										<option value="pending">Pending</option>
										<option value="call me later">Call me later</option>
										<option value="done">Done</option>
										<option value="not interested">Not interested</option>										
									</select>
									{{-- <input type="text" name="response" id="response" class="form-control @error('response') is-invalid @enderror" placeholder="Enter Follow Up Date" value="{{ old('response') }}"> --}}
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-2">
									<label for="remarks">Remarks: (Optional)</label>

									@error('remarks') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="Enter Remarks" value="{{ old('remarks') }}">
								</div>
							</div>
						</div>

						<div class="form-group mb-2">
							<label for="query">Query: (Optional)</label>

							@error('query') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<input type="text" name="query" id="query" class="form-control @error('query') is-invalid @enderror" placeholder="Enter Query of Customer" value="{{ old('query') }}">
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