@extends('parent')

@section('stylesheet')
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">
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
	<script>
		jQuery(document).ready( function () {
		    jQuery('#arrangeTable').DataTable();

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
            		url: '{{ route('change_package_status') }}',
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
					<span>CREATE PACKAGE</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Package</li>
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
							<form action="{{ route('create_package') }}" method="post" accept-charset="utf-8">
								@csrf
								<div class="form-group">
									<label for="package_name">Package name: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('package_name') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="package_name" id="package_name" class="form-control" placeholder="Enter package name" value="{{ old('package_name') }}">
								</div>

								<div class="form-group">
									<label for="price">Price: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('price')
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="price" id="price" class="form-control" placeholder="Set price" value="{{ old('price') }}">
								</div>

								<div class="form-group">
									<label for="no_of_days">Number of Days: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('no_of_days')
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="no_of_days" id="no_of_days" class="form-control" placeholder="Set Number of Days" value="{{ old('no_of_days') }}">
								</div>


								<div class="form-group">
									<label for="pattern">Pattern: (Optional)</label>

									@error('pattern') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<select name="pattern" class="form-control">
										<option selected disabled>Select pattern</option>
										<option value="daily">Daily</option>
										<option value="weekly">Weekly</option>
										<option value="fortnightly">Fortnightly</option>
										<option value="monthly">Monthly</option>
										<option value="quarterly">Quarterly</option>
										<option value="half-yearly">Half-Yearly</option>
										<option value="yearly">Yearly</option>
										<option value="other">Other</option>
									</select>
								</div>

								<div class="form-group">
									<label for="description">Description: (Optional)</label>

									@error('description') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
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
					<span>PACKAGE LIST</span>
				</div>
				<div class="card-body">
					<table class="table table-striped table-hover table-bordered tbody_edit" id="arrangeTable"> 
						<thead>
							<tr>
								<th class="fit">Serial no</th>
								<th class="fit">Package name</th>
								<th class="fit">Price</th>
								<th class="fit">Pattern</th>
								<th class="fit">No of Days</th>
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
							@foreach ($packages as $element)
								<tr>
									<td class="fit">{{ ++$i }}</td>
									<td class="fit">{{ $element->package_name }}</td>
									<td class="fit">{{ $element->fee }}</td>
									<td class="fit">{{ $element->pattern }}</td>
									<td class="fit">{{ $element->no_of_days }}</td>
									<td class="fit">{{ $element->description }}</td>
									<td class="fit">{{ $element->created_at }}</td>
									<td class="fit">
										<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>
									</td>
									<td class="fit">
										<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_package', ['d' => $element->id]) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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