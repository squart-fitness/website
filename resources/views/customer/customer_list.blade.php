@extends('parent')

@section('stylesheet')
	
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/DataTables/DataTables-1.10.22/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/DataTables/Buttons-1.6.5/css/buttons.dataTables.min.css')}}"/> --}}

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/sc-2.0.3/datatables.min.css"/>
 
	<style type="text/css">
		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
		}

		.tbody_edit{
			font-size: 14px;
		}

		.c_image_wrapper{
			/*overflow: hidden;*/
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

		.resize_tab_width{
			width: 70vw;
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

		#datatable_length{
			margin-right: 20px;
		}
	</style>

@endsection

@section('script_up')

	
@endsection

@section('script_down')

	{{-- <script src="{{asset('assets/libraries/DataTables/DataTables-1.10.22/js/jquery.dataTables.min.js')}}"></script> --}}


	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/sc-2.0.3/datatables.min.js"></script>

	{{-- <script src="{{ asset('assets/libraries/js/jquery.hoverImageEnlarge.js') }}"></script> --}}




	<script>
		jQuery(document).ready( function () {
		    var $ = jQuery;

		    // $(".c_image_wrapper").hoverImageEnlarge();
		    
		    $('#datatable').DataTable({
		    	dom: 'lBfrtip',
		        buttons: [
		            'excel', 'print', 'copy'
		        ]
		    });

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

		    //delete a customer
		    $('.delete').on('click', function(){
		    	var link = $(this).attr('data-link');
		    	$('#deleteModal form').attr('action', link);
		    });

		    //change customer status 
	        $('.status').on('click', function(){
	        	var s_data = $(this).attr('data-s');
	        	var d_data = $(this).attr('data-d');
	        	var current = $(this);
	        	$.ajax({
	        		method: 'GET',
	        		url: '{{ route('change_customer_status') }}',
	        		data: {s: s_data, d: d_data},
	        		success:function(data){
	        			if(data != 'failed'){
	        				current.attr('data-s', data);

	        				if(data == 1){
	        					current.html('<i class="fa fa-check-circle" aria-hidden="true"></i>')
	        				}
	        				else{
	        					current.html('<i class="fa fa-times-circle" aria-hidden="true"></i>');
	        				}
	        				alert('Status Changed');
	        				
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
					<h1 class="h1">Member List</h1>
					<p class="lead">List of all members of your gym.</p>
					
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_customer') }}">Member</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Member list</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">	
					<div class="table-responsive">
						<div class="resize_tab_width">
							<table class="display table table-striped table-hover table-bordered tbody_edit" id="datatable"> 
								<thead>
									<tr>
										<th>No</th>
										<th class="fit"></th>
										<th class="fit">Member ID</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Email</th>
										<th class="fit">Gender</th>
										<th class="fit">Height</th>
										<th class="fit">Weight</th>
										<th class="fit">Dob</th>
										<th class="fit">Package</th>
										<th class="fit">Fee</th>
										<th class="fit">Batch</th>
										<th class="fit">Goal</th>
										<th class="fit">Joined at</th>
										<th class="fit">Address</th>
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
									@foreach ($customers as $element)
										{{-- expr --}}
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">
												<div class="c_image_wrapper">
													@if ($element->customer_image)
														<img src="{{ asset('assets/c_images/'.$element->customer_image) }}" class="c_img rounded-circle" alt="customer image">
													@else
														<img src="{{ asset('assets/images/avatar/c_avatar.png') }}" class="c_img" alt="customer image">
													@endif
												</div>
											</td>
											<td class="fit"><a href="{{ route('customer_profile', ['username' =>$element->username, 'd' => $element->id]) }}">{{ $element->username }}</a></td>
											<td class="fit">{{ ucfirst($element->name) }}</td>
											<td class="fit">{{ $element->phone }}</td>
											<td class="fit">{{ $element->email }}</td>
											<td class="fit">{{ ucfirst($element->gender) }}</td>
											<td class="fit">{{ $element->height }}</td>
											<td class="fit">{{ $element->weight }}</td>
											<td class="fit">
												@isset ($element->dob)
													{{ date("d-m-Y", strtotime($element->dob)) }}			
												@endisset
											</td>
											<td class="fit">{{ ucfirst($element->package) }}</td>
											<td class="fit">{{ $element->fee }}</td>
											<td class="fit">{{ ucfirst($element->batch) }}</td>
											<td class="fit">{{ ucfirst($element->goal) }}</td>
											<td class="fit">{{ date("d-m-Y", strtotime($element->created_at)) }}</td>
											<td class="fit">{{ ucfirst($element->address) }}</td>
											<td class="fit">{{ ucfirst($element->remark) }}</td>
											<td class="fit">
											    <a href="{{ route('update_customer', ['d' => $element->id]) }}" class="edit"><i class="fa fa-edit"></i></a>
											</td>
											<td class="fit">
												<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>
											</td>
											<td class="fit">
												<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_customer', ['d' => $element->id]) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
									@endforeach
									

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!---  show full image of members on click in the division element -->
			<div class="full_image">
				<div class="d-flex justify-content-center">
					<img src="{{ asset('assets/images/avatar/c_avatar.png') }}" alt="member full image">					
				</div>
			</div>
		</div>
	</div>

@endsection