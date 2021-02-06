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



	<script>
		jQuery(document).ready( function () {
		    var $ = jQuery;

		    $('#datatable').DataTable({
		    	dom: 'Blfrtip',
		        buttons: [
		            'excel', 'print', 'copy'
		        ]
		    });
		});

	</script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>ENQUIRY CONVERGENCE REPORT</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Enquiry Convergence</li>
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
										<th class="fit"></th>
										<th class="fit">Enquiry id</th>
										<th class="fit">Date</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
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
									</tr>
								</thead>
								<tbody>
									@php
										$i = 0;
									@endphp
									@foreach ($reports as $element)
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

									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection