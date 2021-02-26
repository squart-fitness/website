@extends('parent')

@section('stylesheet')
	
	<style>
		.right-panel{
			background-color: #fff;
		}

		.list-group-item{
			padding: .25rem .55rem;
			border: none;
		}

		.x_left_content:after{
			content: '';
			position: absolute;
			top: 0;
			left: 100%;
			height: 100%;
			border-right: 0.5px solid #ddd;
		}

		.custom-select{
			width: 80%;
		}
		
	</style>
	
@endsection

@section('script_up')

	
@endsection

@section('script_down')
	
	<script>
		var $ = jQuery;
		$('#staff_list').on('change', function(){
			var id, name, phone, email, position;
			id = $('#staff_list option:selected').val();
			name = $('#staff_list option:selected').attr('data-name');
			email = $('#staff_list option:selected').attr('data-email');
			phone = $('#staff_list option:selected').attr('data-phone');
			position = $('#staff_list option:selected').attr('data-position');

			$('#staff_name').text('Name: '+name);
			$('#staff_phone').text('Phone: '+phone);
			$('#staff_email').text('Email: '+email);
			$('#staff_position').text('Position: '+position);
		});
	</script>

@endsection

@section('content')
	
	<div class="content">
		<div class="container">
		  {{-- <h4>Setting</h4> --}}
		  {{-- <br> --}}
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs">
		    <li class="nav-item">
		      <a class="nav-link active" data-toggle="tab" href="#staff_permission">Staff Permission</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#menu1">Menu 1</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
		    </li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div id="staff_permission" class="container tab-pane active"><br>
		      	<h5 class="mb-4">Staff Permission</h5>
		      	<div class="x_panel">
		      		<div class="row">
		      			<div class="col-12 col-md-4">
		      				<div class="x_left_content">
		      					<select name="staff_list" class="custom-select" id="staff_list">
								    <option selected>Select staff</option>
								    @foreach ($emp_list as $element)
									    <option value="{{$element->id}}" 
									    	    data-name="{{ $element->name }}" 
									    	    data-phone="{{$element->phone}}"
									    	    data-email="{{$element->email}}"
									    	    data-position="{{$element->designation}}">

									    {{$element->name}}</option>
								    @endforeach
								 </select>

								 <ul class="list-group">
								     <li class="list-group-item" id="staff_name">Name: </li>
								     <li class="list-group-item" id="staff_phone">Phone: </li>
								     <li class="list-group-item" id="staff_email">Email: </li>
								     <li class="list-group-item" id="staff_position">Position: </li>
								 </ul>
		      				</div>
		      			</div>
		      			<div class="col-12 col-md-8">
		      				<div class="x_right_content">
		      					<ul class="list-group">
		      						<form action="#" method="post" accept-charset="utf-8">
		      							@csrf

		      							<input type="hidden" name="emp_id" id="emp_id">
		      							<li class="list-group-item">
									     	<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw0">
											    <label class="custom-control-label" for="sw0">Dashboard</label>
											</div>
										</li>
		      							<li class="list-group-item">
									     	<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw1">
											    <label class="custom-control-label" for="sw1">Enquiry Add</label>
											</div>
										</li>
										<li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw2">
											    <label class="custom-control-label" for="sw2">Enquiry Detail</label>
											</div>
										</li>
										<li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw3">
											    <label class="custom-control-label" for="sw3">Enquiry Status</label>
											</div>
										</li>
										<li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw4">
											    <label class="custom-control-label" for="sw4">Enquiry Delete</label>
											</div>
										</li>
										<li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw5">
											    <label class="custom-control-label" for="sw5">Enquiry Update</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw6">
											    <label class="custom-control-label" for="sw6">Enquiry Move</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw7">
											    <label class="custom-control-label" for="sw7">Enquiry Profile</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw8">
											    <label class="custom-control-label" for="sw8">Member Add</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw9">
											    <label class="custom-control-label" for="sw9">Member Detail</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw10">
											    <label class="custom-control-label" for="sw10">Member Status</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw11">
											    <label class="custom-control-label" for="sw11">Member Delete</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw_mupdate">
											    <label class="custom-control-label" for="sw_mupdate">Member Update</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw12">
											    <label class="custom-control-label" for="sw12">Member Profile</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw13">
											    <label class="custom-control-label" for="sw13">Member Attendance Add</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw14">
											    <label class="custom-control-label" for="sw14">Member Attendance View</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw15">
											    <label class="custom-control-label" for="sw15">Member Payment Add</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw16">
											    <label class="custom-control-label" for="sw16">Member Payment Detail</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw17">
											    <label class="custom-control-label" for="sw17">Staff Add</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw18">
											    <label class="custom-control-label" for="sw18">Staff Detail</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw19">
											    <label class="custom-control-label" for="sw19">Staff Status</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw20">
											    <label class="custom-control-label" for="sw20">Staff Update</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw21">
											    <label class="custom-control-label" for="sw21">Staff Salary Add</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw22">
											    <label class="custom-control-label" for="sw22">Staff Salary Detail</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw23">
											    <label class="custom-control-label" for="sw23">Creating Diet Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw24">
											    <label class="custom-control-label" for="sw24">Assign Diet Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw25">
											    <label class="custom-control-label" for="sw25">View Assigned Diet Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw26">
											    <label class="custom-control-label" for="sw26">Creating Workout Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw27">
											    <label class="custom-control-label" for="sw27">Assign Workout Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw28">
											    <label class="custom-control-label" for="sw28">View Assigned Workout Plan</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw29">
											    <label class="custom-control-label" for="sw29">Create And View Package</label>
											</div>											
									    </li>
									    <li class="list-group-item">
											<div class="custom-control custom-switch">
											    <input type="checkbox" name="permission[]" class="custom-control-input" id="sw30">
											    <label class="custom-control-label" for="sw30">Create And View Batch</label>
											</div>											
									    </li>

									    <button type="button" class="btn btn-primary">Save</button>

		      						</form>
								 </ul>
		      				</div>
		      			</div>
		      		</div>
		      	</div>
		    </div>
		    <div id="menu1" class="container tab-pane fade"><br>
		      <h3>Menu 1</h3>
		      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		    </div>
		    <div id="menu2" class="container tab-pane fade"><br>
		      <h3>Menu 2</h3>
		      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
		    </div>
		  </div>
		</div>
	</div>

@endsection