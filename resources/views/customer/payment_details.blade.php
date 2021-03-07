@extends('parent')

@section('stylesheet')
	
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}"> --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/sc-2.0.3/datatables.min.css"/>

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

		.resize_tab_width{
			width: 70vw;
		}
		#arragneTable_length{
			margin-right: 20px;
		}
		#pending_datatable_length{
			margin-right: 20px;
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
        	$('#arrangeTable').DataTable({
		    	dom: 'Blfrtip',
		        buttons: [
		            'excel', 'print', 'copy'
		        ]
		    });

		    $('#pending_datatable').DataTable({
		    	dom: 'Blfrtip',
		        buttons: [
		            'excel', 'print', 'copy'
		        ]
		    });


            $('#date_search').on('click',function(){
            	var s_date = $('#s_date').val();
            	var e_date = $('#e_date').val();
            	var list = '';
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('filter_payment_by_date') }}',
            		data: {initial: s_date, final: e_date},
            		success:function(data){
            			var i = 0;
            			for(object of data){
            				list += '<tr>'+
	            				'<td class="fit">'+ ++i +'</td>'+
	            				'<td class="fit">'+ object.username +'</td>'+
								'<td class="fit">'+ object.name +'</td>'+
								'<td class="fit">'+ object.phone +'</td>'+
								'<td class="fit">'+ object.total_amount +'</td>'+
								'<td class="fit">'+ object.discount +'</td>'+
								'<td class="fit">'+ object.paid_amount +'</td>'+
								'<td class="fit">'+ object.due_amount +'</td>'+
								'<td class="fit">'+ object.purpose +'</td>'+
								'<td class="fit">'+ object.payment_mode +'</td>'+
								'<td class="fit">'+ object.created_at +'</td>'+
								'<td class="fit">'+ object.period_start +'</td>'+
								'<td class="fit">'+ object.period_end +'</td>'+
								'</tr>';
            			}

            			$('#filterByMonth').html(list);
            		}
            	});
            });


            $('#expiring_search').on('click',function(){
            	var e = $('#expiring_days').val();
            	var list = '';
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('filter_payment_by_expiring_days') }}',
            		data: {expiring_days: e},
            		success:function(data){
            			var i = 0;
            			for(object of data){
            				list += '<tr>'+
	            				'<td class="fit">'+ ++i +'</td>'+
	            				'<td class="fit">'+ object.username +'</td>'+
								'<td class="fit">'+ object.name +'</td>'+
								'<td class="fit">'+ object.phone +'</td>'+
								'<td class="fit">'+ object.total_amount +'</td>'+
								'<td class="fit">'+ object.discount +'</td>'+
								'<td class="fit">'+ object.paid_amount +'</td>'+
								'<td class="fit">'+ object.due_amount +'</td>'+
								'<td class="fit">'+ object.purpose +'</td>'+
								'<td class="fit">'+ object.payment_mode +'</td>'+
								'<td class="fit">'+ object.created_at +'</td>'+
								'<td class="fit">'+ object.period_start +'</td>'+
								'<td class="fit">'+ object.period_end +'</td>'+
								'</tr>';
            			}

            			$('#filterByMonth').html(list);
            		}
            	});
            });
		});
	</script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>CUSTOMER PAYMENT DETAILS</span>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('customer_payment') }}">Payment</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Payment details</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card mb-5">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>PAYMENT DETAILS</span>
						</div>
						<div class="float_item">
							<a href="{{route('customer_payment')}}"><button class="btn btn-secondary">Make payment</button></a>
						</div>
					</div>
				</div> --}}
				<div class="card-body">	
					<div class="row">
						{{-- <div class="col-12 col-md-2">
							<div class="form-group">
								<select name="month" class="custom-select" id="month">
									<option selected disabled>Select Month</option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>	
						</div> --}}
						<div class="col-12 col-md-2">
							<div class="form-group">
								<input type="text" name="s_date" id="s_date" onfocus="(this.type='date')" class="form-control" placeholder="From date">
							</div>
						</div>
						<div class="col-12 col-md-2">
							<div class="form-group">
								<input type="text" name="e_date" id="e_date" onfocus="(this.type='date')" class="form-control" placeholder="To date">
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="date_search">Search by date</button>
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-12 col-md-3">
							<div class="input-group mb-3">
  								<input type="number" name="expiring_days" id="expiring_days" class="form-control" placeholder="Expiring in days">
  								<div class="input-group-append">
    								<button class="btn btn-danger" type="button" id="expiring_search">Search</button>
  								</div>
							</div>
						</div>
					</div>
					<hr>

					<div class="table-responsive">
						<div class="resize_tab_width">
							<table class="table table-striped table-hover table-bordered" id="arrangeTable"> 
								<thead>
									<tr>
										<th class="fit">Serial no</th>
										<th class="fit">Member ID</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Total amount</th>
										<th class="fit">Discount</th>
										<th class="fit">Paid amount</th>
										<th class="fit">Due amount</th>
										<th class="fit">Purpose</th>
										<th class="fit">Pay mode</th>
										<th class="fit">Pay date</th>
										<th class="fit">Period start</th>
										<th class="fit">Period end</th>
										<th class="fit">Invoice</th>
									</tr>
								</thead>
								<tbody id="filterByMonth">
									@php
										$i = 0;
									@endphp
									@foreach ($payments as $element)
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">{{ $element->username }}</td>
											<td class="fit">{{ $element->name }}</td>
											<td class="fit">{{ $element->phone }}</td>
											<td class="fit">{{ $element->total_amount }}</td>
											<td class="fit">{{ $element->discount }}</td>
											<td class="fit">{{ $element->paid_amount }}</td>
											<td class="fit">{{ $element->due_amount }}</td>
											<td class="fit">{{ $element->purpose }}</td>
											<td class="fit">{{ $element->payment_mode }}</td>
											<td class="fit">{{ $element->created_at }}</td>
											<td class="fit">{{ $element->period_start }}</td>
											<td class="fit">{{ $element->period_end }}</td>
											<td class="fit text-center"><a href="{{route('generate_invoice', ['d' => $element->id])}}" target="_blank" class="text-danger"><h5><i class="fas fa-file-pdf"></i></h5></a></td>
										</tr>
									@endforeach
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>

			{{-- pending paments --}}
			<div class="card mb-5">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>PENDING PAYMENTS</span>
						</div>
						{{-- <div class="float_item">
							<a href="{{route('customer_payment')}}"><button class="btn btn-secondary">Make payment</button></a>
						</div> --}}
					</div>
				</div>
				<div class="card-body">	
						{{-- <div class="row">
							<div class="col-12 col-md-2">
								<div class="form-group">
									<select name="month" class="custom-select" id="month">
										<option selected disabled>Select Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
								</div>	
							</div>
						</div> --}}
					<div class="table-responsive">
						<div class="resize_tab_width">
							<table class="table table-striped table-hover table-bordered" id="pending_datatable"> 
								<thead>
									<tr>
										<th class="fit">Serial no</th>
										<th class="fit">Member ID</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Total amount</th>
										<th class="fit">Discount</th>
										<th class="fit">Paid amount</th>
										<th class="fit">Due amount</th>
										<th class="fit">Purpose</th>
										<th class="fit">Pay mode</th>
										<th class="fit">Pay date</th>
										<th class="fit">Period start</th>
										<th class="fit">Period end</th>
									</tr>
								</thead>
								<tbody>
									@php
										$i = 0;
									@endphp
									@foreach ($pendingPayments as $element)
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">{{ $element->username }}</td>
											<td class="fit">{{ $element->name }}</td>
											<td class="fit">{{ $element->phone }}</td>
											<td class="fit">{{ $element->total_amount }}</td>
											<td class="fit">{{ $element->discount }}</td>
											<td class="fit">{{ $element->paid_amount }}</td>
											<td class="fit">{{ $element->due_amount }}</td>
											<td class="fit">{{ $element->purpose }}</td>
											<td class="fit">{{ $element->payment_mode }}</td>
											<td class="fit">{{ $element->created_at }}</td>
											<td class="fit">{{ $element->period_start }}</td>
											<td class="fit">{{ $element->period_end }}</td>
										</tr>
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