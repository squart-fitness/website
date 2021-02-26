@extends('parent')

@section('stylesheet')
	
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}"> --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/sc-2.0.3/datatables.min.css"/>

	<style type="text/css">
		.content{
			font-family: sans-serif;
			font-size: 14px;
		}
		.table td.fit, .table th.fit {
		    white-space: nowrap;
		    width: 1%;
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
		.addit{
			font-size: 18px;
		}

		.resize_tab_width{
			width: 70vw;
		}

		.pagination {
		  	display: inline-block;
		}

		.pagination a {
		  	color: black;
		  	float: left;
		  	padding: 4px 8px;
		  	border: 1px solid #ddd;
		  	text-decoration: none;
		  	margin: 0 2px;
		}

		.pagination a.active {
		  	background-color: #4CAF50;
		  	color: white;
		}

		.pagination a:hover:not(.active) {
			background-color: #ddd;
		}
	</style>

@endsection

@section('script_down')

	{{-- <script src={{asset('assets/libraries/js/jquery.dataTables.min.js')}}></script> --}}
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/sc-2.0.3/datatables.min.js"></script>


	<script>
		jQuery(document).ready( function () {
		    var $ = jQuery;

		    $('#datatable').DataTable({
		    	dom: 'B',
		        buttons: [
		            'excel', 'print', 'copy'
		        ]
		    });

		    //delete enquiry from list
		    $('.delete').on('click', function(){
		    	var link = $(this).attr('data-link');
		    	$('#deleteModal form').attr('action', link);
		    });

		    //filter by date
            $('#dateButton').on('click keyup',function(){
            	var startDate = $('#s_date').val();
            	var endDate = $('#e_date').val();
            	var list = '';
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('month_enquiry_details') }}',
            		data: {start_date: startDate, end_date: endDate},
            		success:function(data){
            			if(data.length <= 0){
            				list = "<p>No data for this month</p>";
            			}
            			var count = 0;
            			for(object of data){
            				count++;
            				var dt = new Date(Date.parse(object.created_at));
            				var status = object.status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>';
            				var s = '<a data-s="'+ object.status +'" data-d="'+object.id+'" class="status">'+ status + '</a>';

            				var a = '<a href="{{ route('move_enquiry') }}?eid='+object.enquiry_id+' "class="addit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>';

            				var e = '<a href="{{ route('update_enquiry') }}?d='+object.id+' " class="edit"><i class="fa fa-edit"></i></a>';

            				var d = '<a href="{{ route('delete_enquiry') }}?d='+object.id+' " class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';

            				list += '<tr>'+
            					'<td class="fit">'+ count +'</td>'+
            					'<td class="fit">'+ object.enquiry_id +'</td>'+
	            				'<td class="fit">'+ dt.getDate()+'-'+ (dt.getMonth()+1) +'-'+dt.getFullYear() +'</td>'+
								'<td class="fit">'+ object.customer_name +'</td>'+
								'<td class="fit">'+ object.customer_phone +'</td>'+
								'<td class="fit">'+ nullCheck(object.customer_email) +'</td>'+
            					'<td class="fit">'+ object.gender +'</td>'+
								'<td class="fit">'+ nullCheck(object.goal) +'</td>'+
								'<td class="fit">'+ nullCheck(object.plan_interested) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.source_of_enquiry) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.height) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.weight) +'</td>'+
								'<td class="fit">'+ nullCheck(object.followup_date) +'</td>'+
								'<td class="fit">'+ nullCheck(object.trail_date) +'</td>'+
								'<td class="fit">'+ nullCheck(object.query) +'</td>'+
								'<td class="fit">'+ nullCheck(object.response) +'</td>'+
								'<td class="fit">'+ nullCheck(object.remarks) +'</td>'+
								'<td class="fit">'+ nullCheck(object.customer_address) +'</td>'+
								'<td class="fit">'+ a +'</td>'+
								'<td class="fit">'+ e +'</td>'+
								'<td class="fit">'+ s +'</td>'+
								'<td class="fit">'+ d +'</td>'+
								'</tr>';
            			}

            			$('#filterData').html(list);
            		}
            	});
            });            


            $('#search_btn').on('click keyup', function(){
            	var filter_by = $('#filter_by option:selected').val();
            	var filter_value = $('#filter_value').val();
            	var list = '';
            	if(filter_by === "" || filter_value === ""){
            		return;
            	}

            	$.ajax({
            		method: 'get',
            		url: "{{ route('filter_enquiry') }}",
            		data: {by: filter_by, value: filter_value},
            		success: function(data){
            			var i = 0;
            			if(data.length <= 0){
            				list = "<p>No data for this month</p>";
            			}

            			var count = 0;
            			for(object of data){
            				count++;
            				var dt = new Date(Date.parse(object.created_at));
            				var status = object.status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>';
            				var s = '<a data-s="'+ object.status +'" data-d="'+object.id+'" class="status">'+ status + '</a>';

            				var a = '<a href="{{ route('move_enquiry') }}?eid='+object.enquiry_id+' "class="addit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>';

            				var e = '<a href="{{ route('update_enquiry') }}?d='+object.id+' " class="edit"><i class="fa fa-edit"></i></a>';

            				var d = '<a href="{{ route('delete_enquiry') }}?d='+object.id+' " class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            				
            				list += '<tr>'+
            					'<td class="fit">'+ count +'</td>'+
            					'<td class="fit">'+ object.enquiry_id +'</td>'+
	            				'<td class="fit">'+ dt.getDate()+'-'+ (dt.getMonth()+1) +'-'+dt.getFullYear() +'</td>'+
								'<td class="fit">'+ object.customer_name +'</td>'+
								'<td class="fit">'+ object.customer_phone +'</td>'+
								'<td class="fit">'+ nullCheck(object.customer_email) +'</td>'+
            					'<td class="fit">'+ object.gender +'</td>'+
								'<td class="fit">'+ nullCheck(object.goal) +'</td>'+
								'<td class="fit">'+ nullCheck(object.plan_interested) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.source_of_enquiry) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.height) +'</td>'+
            					'<td class="fit">'+ nullCheck(object.weight) +'</td>'+
								'<td class="fit">'+ nullCheck(object.followup_date) +'</td>'+
								'<td class="fit">'+ nullCheck(object.trail_date) +'</td>'+
								'<td class="fit">'+ nullCheck(object.query) +'</td>'+
								'<td class="fit">'+ nullCheck(object.response) +'</td>'+
								'<td class="fit">'+ nullCheck(object.remarks) +'</td>'+
								'<td class="fit">'+ nullCheck(object.customer_address) +'</td>'+
								'<td class="fit">'+ a +'</td>'+
								'<td class="fit">'+ e +'</td>'+
								'<td class="fit">'+ s +'</td>'+
								'<td class="fit">'+ d +'</td>'+
								'</tr>';
            			}

            			$('#filterData').html(list);
            		}
            	})
            });

		});

		//change enquiry status 
        jQuery(document).on('click', '.status', function(){
        	var $ = jQuery;
        	var s_data = $(this).attr('data-s');
        	var d_data = $(this).attr('data-d');
        	var current = $(this);
        	$.ajax({
        		method: 'GET',
        		url: '{{ route('change_enquiry_status') }}',
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

        //check for null values
		function nullCheck(value){
			if(value == null){
				return "";
			}
			else{
				return value;
			}
		}
	</script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">
			@if (Session::has('msg'))
				<div class="alert alert-success">
					{!! Session::get('msg') !!}
				</div>
			@endif
			


			<div class="d-flex justify-content-between">
				<div class="float_item align-self-center">
					<span>ENQUIRY LIST</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">
		  				<ol class="breadcrumb">
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_enquiry') }}">Enquiry</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Enquiry Detail</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>ENQUIRY LIST</span>
						</div>
						<div class="float_item">
							<a href="{{route('add_enquiry')}}"><button class="btn btn-secondary btn-sm">Add Enquiry</button></a>
						</div>
					</div>
				</div> --}}
				<div class="card-body">	
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="input-group">
								<select name="filter_by" class="custom-select mr-2 mb-2" id="filter_by">
									<option selected disabled>Filter By</option>
									<option value="enquiryid">Enquiry id</option>
									<option value="name">Name</option>
									<option value="phone">Phone</option>
									<option value="goal">Goal</option>
									<option value="gender">Gender</option>
									<option value="plan">Plan</option>
									<option value="followUp">Follow Up Date</option>
									<option value="trail">Trail Date</option>
									<option value="remarks">Remarks</option>
									<option value="address">Address</option>
									<option value="height">Height</option>
									<option value="weight">Weight</option>
								</select>

								<input type="text" name="filter_value" placeholder="Enter filteration" class="form-control mr-2 mb-2" id="filter_value">
								<button type="button" class="btn btn-primary mb-2" id="search_btn">Search</button>

							</div>
						</div>
						<div class="col-12 col-md-1	"></div>
						<div class="col-12 col-md-5">
							<div class="input-group">
								<input type="date" name="s_date" class="form-control mr-2 mb-2" id="s_date">
								<input type="date" name="e_date" class="form-control mr-2 mb-2" id="e_date">
								<button type="button" class="btn btn-primary mb-2" id="dateButton">Find</button>
							</div>
						</div>

					</div>
					{{-- {{$enquiries}} --}}
					<div class="table-responsive">
						<div class="resize_tab_width">
							<table class="table table-striped table-hover table-bordered" id="datatable"> 
								<thead>
									<tr>
										<th class="fit"></th>
										<th class="fit">Enquiry id</th>
										<th class="fit">Date</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Email</th>
										<th class="fit">Gender</th>
										<th class="fit">Goal</th>
										<th class="fit">Plan</th>
										<th class="fit">Source of enquiry</th>
										<th class="fit">Height</th>
										<th class="fit">Weight</th>
										<th class="fit">Follow up date</th>
										<th class="fit">Trail date</th>
										<th class="fit">Query</th>
										<th class="fit">Response</th>
										<th class="fit">Remarks</th>
										<th class="fit">Address</th>
										<th class="fit"></th>
										<th class="fit"></th>
										<th class="fit"></th>
										<th class="fit"></th>
									</tr>
								</thead>
								<tbody id="filterData">
									@php
										$i = 0;
									@endphp
									@foreach ($enquiries as $element)
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">
												@isset ($element->enquiry_id)
													<a href="{{route('enquiry_profile', ['eid' => $element->enquiry_id])}}">
														{{$element->enquiry_id}}
													</a>
												@endisset
											</td>
											<td class="fit">{{ date("d-m-Y", strtotime($element->created_at)) }}</td>
											<td class="fit">{{ ucfirst($element->customer_name) }}</td>
											<td class="fit">{{ $element->customer_phone }}</td>
											<td class="fit">{{ $element->customer_email }}</td>
											<td class="fit">{{ ucfirst($element->gender) }}</td>
											<td class="fit">{{ ucfirst($element->goal) }}</td>
											<td class="fit">{{ ucfirst($element->plan_interested) }}</td>
											<td class="fit">{{ ucfirst($element->source_of_enquiry) }}</td>
											<td class="fit">{{ $element->height }}</td>
											<td class="fit">{{ $element->weight }}</td>
											<td class="fit">{{ $element->followup_date ? date("d-m-Y", strtotime($element->followup_date)) : "" }}</td>
											<td class="fit">{{ $element->trail_date ? date("d-m-Y", strtotime($element->trail_date)) : "" }}</td>
											<td class="fit">{{ ucfirst($element->query) }}</td>
											<td class="fit">{{ ucfirst($element->response) }}</td>
											<td class="fit">{{ ucfirst($element->remarks) }}</td>
											<td class="fit">{{ ucfirst($element->customer_address) }}</td>
											<td class="fit">
												<a href="{{ route('move_enquiry', ['eid' => $element->enquiry_id]) }}" class="addit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
											</td>
											<td class="fit">
											    <a href="{{ route('update_enquiry', ['d' => $element->id]) }}" class="edit"><i class="fa fa-edit"></i></a>
											</td>
											<td class="fit">
												<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>
											</td>
											<td class="fit">
												<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_enquiry', ['d' => $element->id]) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
									@endforeach
									
								</tbody>
							</table>	
						</div>
					</div>
					<div class="pagination mt-4">
						@if(empty(!$enquiries->previousPageUrl()))
							<a href="{{ $enquiries->previousPageUrl() }}">Previous</a>
						@endif

						@if (empty(!$enquiries->nextPageUrl()))
							<a href="{{ $enquiries->nextPageUrl() }}">Next</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection