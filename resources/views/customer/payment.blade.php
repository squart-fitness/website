@extends('parent')

@section('stylesheet')
	
	<style type="text/css">
		@media(max-width: 768px){
			.content{
				padding-left: 5px;
				padding-right: 5px;
			}
		}

		#payForm{
			display: block;
		}

		.dropdown_menu{
			display: none;
			position: absolute;
			top: 38px;
			left: 0;
			background-color: #ffffff;
			list-style-type: none;
			z-index: 1000;
			width: 100%;
			padding: 5px 0px;
			box-shadow: 0 2px 5px #444444;
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
		}
		.dropdown_menu .dropdown_item{
			padding: 3px 20px;
		}
		.dropdown_item:hover{
			background-color: #E8E8E8;
		}
	</style>

@endsection

@section('script_down')

	<script>
		jQuery(document).ready(function(){
            var $ = jQuery;
            $('#search').on('click keyup',function(){
            	var memberID = $('#username').val();
            	$.ajax({
            		method: 'GET',
            		url: '{{ route('customer_data') }}',
            		data: {username: memberID},
            		success:function(data){
            			console.log(data);
            			$('#payForm').css('display', 'block');

            			if(Array.isArray(data)){
            				$('#name').val(data[0].name);
	            			$('#phone').val(data[0].phone);
	            			$('#customerID').val(data[0].id);
	            			$('#last_month_due').val(data[0].due_amount);
	            			$('#package_fee').val(data[0].fee);
	            			// $('#per_start').val(data[0].period_end);
	            			$('#total_amt').val(parseFloat(data[0].due_amount) + parseFloat(data[0].fee));
            			}
            			else{
	            			$('#customerID').val(data.id);
	            			$('#name').val(data.name);
	            			$('#phone').val(data.phone);
	            			$('#last_month_due').val("0");
	            			$('#package_fee').val(data.fee);
	            			$('#total_amt').val(parseFloat(data.fee) + parseFloat(0));
            			}
            		}
            	});
            });


            $('#username').on('keyup click', function(){
            	$('#dropdownMe').css({'display': 'block'});
            	var v = $(this).val();
            	var list = '';
            	if(v == "" || v.trim() === ""){
            		return;
            	}
            	$.ajax({
            		method: 'GET',
            		data: {value: v},
            		url: '{{ route('list_username') }}',
            		success:function(result){
            			for(val of result){
            				list += '<li class="dropdown_item">'+val+'</li>'
            			}
            			$('#dropdownMe').html(list);
            		}
            	});	
            });

		});

		jQuery(document).on('click', '.dropdown_item', function(){
			var $ = jQuery;
        	$('#username').val($(this).text());
        	$('#dropdownMe').stopPropagation();	

        });

        jQuery(document).click(function(){
		  jQuery("#dropdownMe").hide();
		});
	</script>

@endsection

@section('content')
	<div class="content">
		<div class="animated fadedIn">
			@if(Session::has('msg'))
				<div class="alert alert-success">
					{!! Session::get('msg') !!}
				</div>
			@endif

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>CUSTOMER PAYMENT</span>
					<a href="{{ route('customer_payment_details') }}" class="btn btn-secondary btn-sm ml-3">Payment details</a>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Payment</li>
		  				</ol>
					</nav>
				</div>
			</div>


			<div class="card">
				{{-- <div class="card-header">
					Customer Payment
				</div> --}}
				<div class="card-body">	
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text input_group_text_modified">Member ID</span>
								</div>
								@error('username') 
								    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
								@enderror
								<input type="text" name="username" id="username" class="form-control" placeholder="Enter member id" autocomplete="off">
								<ul class="dropdown_menu" id="dropdownMe"></ul>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group mb-3">
								<label for=""></label>
								<button type="submit" id="search" class="btn btn-primary btn_size_2">Search</button>
							</div>
						</div>
					</div>

					<hr>
					<form action="{{ route('customer_payment') }}" method="post" accept-charset="utf-8" id="payForm">
						@csrf
						<input type="hidden" name="customer_id" id="customerID" value="">
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="name">Name: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" disabled id="name">
								</div>
								<div class="col-12 col-md-6">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" id="phone" disabled>
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="total_amt">Package fee: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" id="package_fee" disabled>
								</div>
								<div class="col-12 col-md-6">
									<label for="last_month_due">Last Month due: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" id="last_month_due" disabled>
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="total_amt">Total amount: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('total_amt') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="total_amt" class="form-control" id="total_amt" value="{{ old('total_amt') }}">
								</div>
								<div class="col-12 col-md-6">
									<label for="discount">Discount: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('discount') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" 
										   name="discount" 
										   class="form-control" 
										   id="discount" 
										   value="{{ !empty(old('discount')) ? old('discount') : 0 }}"
									/>
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="paid_amt">Paid amount: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('paid_amt') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="paid_amt" class="form-control" id="paid_amt" value="{{ old('paid_amt') }}">
								</div>
								<div class="col-12 col-md-6">
									<label for="due_date">Payment due date: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('due_date') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="due_date" class="form-control" id="due_date" value="{{ old('due_date') }}">
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="purpose">Purpose: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('purpose') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="purpose" class="form-control" id="purpose" value="{{ old('purpose') }}">
								</div>
								<div class="col-12 col-md-6">
									<label for="paymode">Payment mode: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('pay_mode') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="text" name="pay_mode" class="form-control" id="pay_mode" value="{{ old('pay_mode') }}">
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="per_start">Period start: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('per_start') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="per_start" class="form-control" id="per_start" value="{{ old('per_start') }}">
								</div>
								<div class="col-12 col-md-6">
									<label for="per_end">Period end: <span class="text-danger text_size"><sup>*</sup></span></label>

									@error('per_end') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="date" name="per_end" class="form-control" id="per_end" value="{{ old('per_end') }}">
								</div>
							</div>
						</div>		

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection