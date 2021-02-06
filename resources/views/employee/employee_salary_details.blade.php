@extends('parent')

@section('stylesheet')
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">
	<style type="text/css">
		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
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
            $('#month').on('change',function(){
            	var m = $('#month option:selected').val();
            	var list = '';
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('employee_salary_monthly') }}',
            		data: {month: m},
            		success:function(data){
            			var i = 0;
            			for(object of data){
            				list += '<tr>'+
	            				'<td class="fit">'+ ++i +'</td>'+
	            				'<td class="fit">'+ object.username +'</td>'+
								'<td class="fit">'+ object.employee_name +'</td>'+
								'<td class="fit">'+ object.employee_phone +'</td>'+
								'<td class="fit">'+ object.total_amount +'</td>'+
								'<td class="fit">'+ object.paid_amount +'</td>'+
								'<td class="fit">'+ object.due_amount +'</td>'+
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

            $('#date_search').on('click',function(){
            	var s_date = $('#s_date').val();
            	var e_date = $('#e_date').val();
            	var list = '';
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('filter_salary_by_date') }}',
            		data: {initial: s_date, final: e_date},
            		success:function(data){
            			var i = 0;
            			for(object of data){
            				list += '<tr>'+
	            				'<td class="fit">'+ ++i +'</td>'+
	            				'<td class="fit">'+ object.username +'</td>'+
								'<td class="fit">'+ object.employee_name +'</td>'+
								'<td class="fit">'+ object.employee_phone +'</td>'+
								'<td class="fit">'+ object.total_amount +'</td>'+
								'<td class="fit">'+ object.paid_amount +'</td>'+
								'<td class="fit">'+ object.due_amount +'</td>'+
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
					<span>EMPLOYEE SALARY DETAILS</span>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('employee_salary') }}">Salary</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Salary details</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				{{-- <div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>EMPLOYEE SALARY DETAILS</span>
						</div>
						<div class="float_item">
							<a href="{{route('employee_salary')}}"><button class="btn btn-secondary">Add Salary Details</button></a>
						</div>
					</div>
				</div> --}}
				<div class="card-body">	
					<div class="row">
						<div class="col-12 col-md-3">
							<div class="form-group">
								<input type="text" name="s_date" id="s_date" onfocus="(this.type='date')" class="form-control" placeholder="From date">
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="form-group">
								<input type="text" name="e_date" id="e_date" onfocus="(this.type='date')" class="form-control" placeholder="To date">
							</div>
						</div>
						<div class="col-12 col-md-1">
							<div class="form-group">
								<button type="button" class="btn btn-primary" id="date_search">Search by date</button>
							</div>
						</div>
					</div>
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
							<table class="table table-striped table-hover table-bordered" id="arrangeTable"> 
								<thead>
									<tr>
										<th class="fit">Serial no</th>
										<th class="fit">Member ID</th>
										<th class="fit">Name</th>
										<th class="fit">Phone</th>
										<th class="fit">Total amount</th>
										<th class="fit">Paid amount</th>
										<th class="fit">Due amount</th>
										<th class="fit">Pay mode</th>
										<th class="fit">Pay date</th>
										<th class="fit">Period start</th>
										<th class="fit">Period end</th>
									</tr>
								</thead>
								<tbody id="filterByMonth">
									@php
										$i = 0;
									@endphp
									@foreach ($salaries as $element)
										<tr>
											<td class="fit">{{ ++$i }}</td>
											<td class="fit">{{ $element->username }}</td>
											<td class="fit">{{ $element->employee_name }}</td>
											<td class="fit">{{ $element->employee_phone }}</td>
											<td class="fit">{{ $element->total_amount }}</td>
											<td class="fit">{{ $element->paid_amount }}</td>
											<td class="fit">{{ $element->due_amount }}</td>
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