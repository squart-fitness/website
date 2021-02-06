@extends('parent')

@section('stylesheet')
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/timepicker/wickedpicker.min.css')}}">

	<style>
		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
		}

		.tbody_edit{
			font-size: 14px;
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
	</style>
@endsection

@section('script_down')

	<script src={{asset('assets/libraries/js/jquery.dataTables.min.js')}}></script>
	<script src={{asset('assets/vendor/timepicker/wickedpicker.min.js')}}></script>

	<script>
		jQuery(document).ready( function () {
		    jQuery('#arrangeTable').DataTable();
		    jQuery('#start_time').wickedpicker();
		    jQuery('#end_time').wickedpicker();

		    var $ = jQuery;

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
            		url: '{{ route('change_batch_status') }}',
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
					<span>CREATE BATCH</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Batch</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				{{-- <div class="card-header">
					<span>CREATE PACKAGE</span>
				</div> --}}
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-6">
							<form action="{{ route('batch') }}" method="post" accept-charset="utf-8">
								@csrf
								<div class="form-group">
									<label for="batch_name">Batch name:</label>

									@error('batch_name') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="batch_name" id="batch_name" class="form-control" placeholder="Enter batch name" value="{{ old('batch_name') }}">
								</div>

								<div class="form-group">
									<label for="start_time">Start time:</label>

									@error('start_time')
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="start_time" id="start_time" class="form-control" placeholder="Enter start time" value="{{ old('start_time') }}">
								</div>

								<div class="form-group">
									<label for="end_time">End time:</label>

									@error('end_time')
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="end_time" id="end_time" class="form-control" placeholder="Enter end time" value="{{ old('end_time') }}">
								</div>

								<div class="form-group">
									<label for="description">Description:</label>

									@error('description') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
									{{-- <input type="text" name="description" id="description" class="form-control" placeholder="Add package category" value="{{ old('description') }}"> --}}
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn_size_3">Create</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<span>BATCH LIST</span>
				</div>
				<div class="card-body">
					<table class="table table-striped table-hover table-bordered tbody_edit" id="arrangeTable"> 
						<thead>
							<tr>
								<th class="fit">Serial no</th>
								<th class="fit">Batch name</th>
								<th class="fit">Start time</th>
								<th class="fit">End time</th>
								<th class="fit">Description</th>
								<th class="fit">Created date</th>
								<th class="fit"></th>
								<th class="fit"></th>
							</tr>
						</thead>
						<tbody>
							@php
								$i = 0;
							@endphp
							@foreach ($batches as $element)
								<tr>
									<td class="fit">{{ ++$i }}</td>
									<td class="fit">{{ $element->batch_name }}</td>
									<td class="fit">{{ $element->start_time }}</td>
									<td class="fit">{{ $element->end_time }}</td>
									<td class="fit">{{ $element->description }}</td>
									<td class="fit">{{ $element->created_at }}</td>
									<td class="fit">
										<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>
									</td>
									<td class="fit">
										<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_batch', ['d' => $element->id]) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>

									</td>
								</tr>
							@endforeach							
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>

@endsection