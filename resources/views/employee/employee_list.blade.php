@extends('parent')

@section('stylesheet')
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">
	<style type="text/css">
		.content{
			font-family: sans-serif;
			font-size: 14px;
		}
		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
		}
		.c_img{
			max-width: none;
			height: 30px;
			width: 30px;
		}

		.full_image{
			display: none;
			position: absolute;
			background-color: rgba(0,0,0,0.4);
			height: 150%;
			width: 100%;
			top: 0;
			left: 0;
			z-index: 3;
		}
		.full_image img{
		    width: auto;
		    height: fit-content;
		    vertical-align: middle;
		    transform: translateY(20%);
		    z-index: 1000;
		}

		.status{
			padding: 0px 3px;
			border-radius: 50%;
			font-size: 18px;
			cursor: pointer;
		}

		.delete{
			font-size: 18px;
			color: #FD5959;
		}

		.edit{
			font-size: 18px;
		}

		.resize_tab_width{
			width: 70vw;
		}
	</style>
@endsection

@section('script_down')

	<script src={{asset('assets/libraries/js/jquery.dataTables.min.js')}}></script>
	<script>
		jQuery(document).ready( function () {
		    jQuery('#arrangeTable').DataTable();

		    var $ = jQuery;

		    $('.c_image_wrapper').on('click', function(event){
		    	var img_url = $('.c_image_wrapper img');
		    	$('.full_image').css('display', 'block');

		    	var set_image = $('.full_image img');
		    	set_image.attr('src', event.target.currentSrc);
		    	console.log(event.target.currentSrc);
		    });

		    $('.full_image').on('click', function(){
		    	$(this).css('display', 'none');
		    });

		    //delete employee from list
		    $('.delete').on('click', function(){
		    	var link = $(this).attr('data-link');
		    	$('#deleteModal form').attr('action', link);
		    });


		    //change enquiry status 
            $('.status').on('click', function(){
            	var s_data = $(this).attr('data-s');
            	var d_data = $(this).attr('data-d');
            	var current = $(this);
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('change_employee_status') }}',
            		data: {s: s_data, d: d_data},
            		success:function(data){
            			if(data != 'failed'){
            				alert('Status Changed');
            				current.attr('data-s', data);

            				if(data == 1){
	        					current.html('<i class="fa fa-check-circle" aria-hidden="true"></i>')
            				}
            				else{
	        					current.html('<i class="fa fa-times-circle" aria-hidden="true"></i>');
            				}
            			}
            		}
            	});
            });
		});
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
					<span>EMPLOYEE LIST</span>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_employee') }}">Employee</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Employee list</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-start">
						<div class="float_item align-self-center mr-4">
							<span>EMPLOYEE LIST</span>
						</div>
						<div class="float_item">
							<a href="{{route('add_employee')}}"><button class="btn btn-secondary btn-sm">Add Employee</button></a>
						</div>
					</div>
				</div> --}}
				
				<div class="card-body">	
					<div class="table-responsive">
						<div class="resize_tab_width">
							<table class="table table-striped table-hover table-bordered" id="arrangeTable"> 
								<thead>
									<tr>
										<th class="fit">No</th>
										<th class="fit"></th>
										<th class="fit">Member ID</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Email</th>
										<th class="fit">Gender</th>
										<th class="fit">DOB</th>
										<th class="fit">Salary</th>
										<th class="fit">Address</th>
										<th class="fit">Role</th>
										<th class="fit">Designation</th>
										<th class="fit">Remark</th>
										<th class="fit"></th>
										<th class="fit"></th>
										<th class="fit"></th>
									</tr>
								</thead>
								<tbody>
									@php
										$i = 0;
									@endphp
									@foreach ($employees as $element)
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">
												<div class="c_image_wrapper">
													@if ($element->employee_image)
														<img src="{{ asset('assets/e_images/'.$element->employee_image) }}" class="c_img rounded-circle" alt="employee image">
													@else
														<img src="{{ asset('assets/images/avatar/c_avatar.png') }}" class="c_img" alt="employee image">
													@endif
												</div>
											</td>
											<td class="fit">{{ $element->username }}</td>
											<td class="fit">{{ $element->employee_name }}</td>
											<td class="fit">{{ $element->employee_phone }}</td>
											<td class="fit">{{ $element->employee_email }}</td>
											<td class="fit">{{ $element->gender }}</td>
											<td class="fit">{{ $element->dob }}</td>
											<td class="fit">{{ $element->salary }}</td>
											<td class="fit">{{ $element->address }}</td>
											<td class="fit">{{ $element->role == 2 ? 'Normal' : 'Management' }}</td>
											<td class="fit">{{ $element->designation }}</td>
											<td class="fit">{{ $element->remark }}</td>
											<td class="fit">
											    <a href="{{ route('update_employee', ['d' => $element->id]) }}" class="edit"><i class="fa fa-edit"></i></a>
											</td>
											<td class="fit">
												<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>
											</td>
											<td class="fit">
												<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_employee', ['d' => $element->id]) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
									@endforeach								
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>

			<!---  show full image of employees on click in the division element -->
			<div class="full_image">
				<div class="d-flex justify-content-center">
					<img src="{{ asset('assets/images/avatar/c_avatar.png') }}" alt="employee full image">					
				</div>
			</div>
		</div>
	</div>

@endsection