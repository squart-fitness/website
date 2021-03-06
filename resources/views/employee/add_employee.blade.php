@extends('parent')


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
					<span>ADD EMPLOYEE</span>
					<a href="{{route('employee_list')}}"><button class="btn btn-info btn-sm ml-3">Employee List</button></a>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Employee</li>
		  				</ol>
					</nav>
				</div>
			</div>

			
			<div class="card">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>ADD EMPLOYEE</span>
						</div>
						<div class="float_item">
						</div>
					</div>
				</div> --}}
				<div class="card-body">	
					<form action="{{ route('add_employee') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="fullname">Name: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('fullname') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter full name" value="{{ old('fullname') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="phone" id="phone" class="form-control" placeholder="Enter mobile number" value="{{ old('phone') }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="email">Email: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('email') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="email" name="email" id="email" class="form-control" placeholder="Enter email id" value="{{ old('email') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="pass">Password: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('pass') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="pass" id="pass" class="form-control" placeholder="Enter password of joining" value="{{ old('pass') }}">
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
									<select name="gender" class="form-control">
										<option selected disabled value="">Select gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="transgender">Transgender</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="dob">Date of birth: (Optional)</label>

									@error('dob') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="role">Authority Type: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('role') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="role" class="form-control">
										<option selected disabled>Select Authority</option>
										<option value="2">Normal</option>
										<option value="1">Management</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="designation">Designation: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('designation') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="designation" id="designation" class="form-control" placeholder="Enter designation" value="{{ old('designation') }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="salary">Salary: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('salary') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="salary" id="salary" class="form-control" placeholder="Enter salary" value="{{ old('salary') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="remark">Remark: (Optional)</label>

									@error('remark') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="remark" id="remark" class="form-control" placeholder="Enter remark" value="{{ old('remark') }}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="employee_image">Employee Image: (Optional)</label>

									@error('employee_image') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="file" name="employee_image" id="employee_image" class="form-control @error('employee_image') is-invalid @enderror">
								</div>
							</div>
						</div>

						<div class="form-group mb-3">
							<label for="address">Address: <span class="text-danger text_size"><sup>*</sup></span></label>

							@error('address') 
							    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
							@enderror
							<textarea type="text" rows="4" name="address" id="address" class="form-control" placeholder="Enter address">{{ old('address') }}</textarea>
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