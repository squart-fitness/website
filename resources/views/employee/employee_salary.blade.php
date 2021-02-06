@extends('parent')

@section('stylesheet')
	
	<style type="text/css">
		@media(max-width: 768px){
			.content{
				padding-left: 5px;
				padding-right: 5px;
			}
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
            		url: '{{ route('employee_data') }}',
            		data: {username: memberID},
            		success:function(data){            			
            			if(Array.isArray(data)){
            				$('#name').val(data[0].employee_name);
	            			$('#phone').val(data[0].employee_phone);
	            			$('#employeeID').val(data[0].id);
	            			$('#last_month_due').val(data[0].due_amount);
	            			$('#salary').val(data[0].salary);
	            			// $('#per_start').val(data[0].period_end);
	            			$('#total_amt').val(parseFloat(data[0].due_amount) + parseFloat(data[0].salary));
            			}
            			else{
	            			$('#employeeID').val(data.id);
	            			$('#salary').val(data.salary);
	            			$('#name').val("");
	            			$('#phone').val("");
	            			$('#last_month_due').val("0");
	            			$('#total_amt').val(data.salary + 0);
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
            		url: '{{ route('list_employee_username') }}',
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
					<span>EMPLOYEE SALARY</span>	
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('add_employee') }}">Employee</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Employee salary</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">	
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text input_group_text_modified">Member ID</span>
								</div>
								<input type="text" name="username" id="username" class="form-control" placeholder="Enter username" autocomplete="off">
								<ul class="dropdown_menu" id="dropdownMe"></ul>

							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group mb-3">
								<label for=""></label>
								<button type="submit" class="btn btn-primary btn_size_2" id="search">Search</button>
							</div>
						</div>
					</div>
					<hr>
					<form action="{{ route('employee_salary') }}" method="post" accept-charset="utf-8" id="payForm">
						@csrf
						<input type="hidden" name="employee_id" id="employeeID" value="">

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
									<label for="salary">Salary: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" disabled id="salary">
								</div>
								<div class="col-12 col-md-6">
									<label for="last_month_due">Due amount: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" class="form-control" id="last_month_due" disabled>
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="paymode">Payment mode: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" name="pay_mode" class="form-control" id="pay_mode">
								</div>
							</div>
						</div>
						<div class="form-group mb-2">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="total_amt">Total amount: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" name="total_amt" class="form-control" id="total_amt">
								</div>
								<div class="col-12 col-md-6">
									<label for="paid_amt">Paid amount: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" name="paid_amt" class="form-control" id="paid_amt">
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<div class="col-12 col-md-6">
									<label for="per_start">Period start: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="date" name="per_start" class="form-control" id="per_start">
								</div>
								<div class="col-12 col-md-6">
									<label for="per_end">Period end: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="date" name="per_end" class="form-control" id="per_end">
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