@extends('parent')

@section('stylesheet')
	<style type="text/css">
		.content{
			font-family: sans-serif;
			font-size: 14px;
		}
		.actions{
			margin-bottom: 30px;
		}
	</style>

@endsection

@section('script_down')
	
	<script>
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
        					current.text('Activated')
        				}
        				else{
        					current.text('Deactivated');
        				}
        				alert('Status Changed');
        			}
        		}
        	});
        });
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
					<span>ENQUIRY ID {{ $enquiry->enquiry_id }}</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">
		  				<ol class="breadcrumb">
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_enquiry') }}">Enquiry</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('showall_enquiry') }}">Enquiry Detail</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Enquiry Profile</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="actions">
						<div class="d-flex justify-content-around">
							<div class="float_items">
								<a href="{{ route('move_enquiry', ['eid' => $enquiry->enquiry_id]) }}" class="btn btn-primary btn-sm">Add</a>
							</div>
							<div class="float_items">
							    <a href="{{ route('update_enquiry', ['d' => $enquiry->id]) }}" class="btn btn-info btn-sm">Edit</a>
							</div>
							<div class="float_items">
								<a data-s="{{ $enquiry->status }}" data-d="{{ $enquiry->id }}" class="btn btn-secondary btn-sm status">{!! $enquiry->status == 1 ? 'Activated' : 'Deactivated' !!}</a>
							</div>
							<div class="float_items">
								<a href="{{ route('delete_enquiry', ['d' => $enquiry->id]) }}" class="btn btn-danger btn-sm">Delete</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-md-6">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Enquiry id: <span class="text-secondary">{{ ucfirst($enquiry->enquiry_id) }}</span></li>

								<li class="list-group-item">Name: <span class="text-secondary">{{ ucfirst($enquiry->customer_name) }}</span></li>

								<li class="list-group-item">Phone: <span class="text-secondary">{{ ucfirst($enquiry->customer_phone) }}</span></li>

								<li class="list-group-item">Goal: <span class="text-secondary">{{ ucfirst($enquiry->goal) }}</span></li>

								<li class="list-group-item">Plan Interested: <span class="text-secondary">{{ ucfirst($enquiry->plan_interested) }}</span></li>

								<li class="list-group-item">Height: <span class="text-secondary">{{ ucfirst($enquiry->height) }}</span></li>

								<li class="list-group-item">Weight: <span class="text-secondary">{{ ucfirst($enquiry->weight) }}</span></li>
							</ul>
						</div>

						<div class="col-12 col-md-6">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Source of Enquiry: <span class="text-secondary">{{ ucfirst($enquiry->source_of_enquiry) }}</span></li>

								<li class="list-group-item">Follow up date: <span class="text-secondary">{{ ucfirst($enquiry->followup_date) }}</span></li>

								<li class="list-group-item">Trail date: <span class="text-secondary">{{ ucfirst($enquiry->trail_date) }}</span></li>

								<li class="list-group-item">Customer query: <span class="text-secondary">{{ ucfirst($enquiry->query) }}</span></li>

								<li class="list-group-item">Response: <span class="text-secondary">{{ ucfirst($enquiry->response) }}</span></li>

								<li class="list-group-item">Remarks: <span class="text-secondary">{{ ucfirst($enquiry->remarks) }}</span></li>

								<li class="list-group-item">Address: <span class="text-secondary">{{ ucfirst($enquiry->customer_address) }}</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection