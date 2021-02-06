@extends('parent')

@section('stylesheet')

	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/evoCalendar/css/evo-calendar.min.css')}}">	

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
			/*top: 38px;*/
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

		.resize_tab_width{
			width: 70vw;
		}

		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
		}

		.tbody_edit{
			font-size: 14px;
		}

		p{
			color: inherit!important;
		}
	</style>

@endsection

@section('script_down')
	
	<script src={{asset('assets/libraries/js/jquery.dataTables.min.js')}}></script>
	<script src={{asset('assets/libraries/evoCalendar/js/evo-calendar.min.js')}}></script>

	<script>
		var $ = jQuery;
		var remove_arr = [];
		jQuery(document).on('click', '.day', function(){
	    	var d = (jQuery(this).attr('data-date-val'));
        	$('#evo_calendar').evoCalendar('removeCalendarEvent', remove_arr);
        	remove_arr = [];

	    	$.ajax({
        		method: 'GET',
        		data: {date: d},
        		url: '{{ route('attendance_data') }}',
        		success:function(result){
        			var arr = [];
        			for(val of result){
        				arr.push({
        					'id': val.username,
        					'name': val.name,
        					'date': val.attendance_date,
        					'description': "Phone = "+val.phone,
        					'type': 'Attendance',
        					'everyYear': false,
        				});

        				remove_arr.push(val.username);
        			}

        			$('#evo_calendar').evoCalendar('addCalendarEvent', arr);
        		}
        	});	
		});


		jQuery(document).ready( function () {
		    jQuery('#arrangeTable').DataTable();

		    jQuery('#evo_calendar').evoCalendar();

		    //name and phone search by name
		    $('#fullname').on('keyup click', function(){
            	$('#dropdownMe').css({'display': 'block'});
            	var v = $(this).val();
            	var list = '';
            	if(v == "" || v.trim() === ""){
            		return;
            	}
            	$.ajax({
            		method: 'GET',
            		data: {name: v},
            		url: '{{ route('list_names') }}',
            		success:function(result){
            			for(val of result){
            				list += '<li class="dropdown_item" data="'+val[1]+'">'+val[0]+'</li>'
            			}
            			$('#dropdownMe').html(list);
            		}
            	});	
            });

		    // //attendace search by month
      //       $('#month').on('click keyup',function(){
      //       	var m = $('#month option:selected').val();
      //       	var d = $('#cus_id option:selected').val();
      //       	if(d === "0"){
      //       		return;
      //       	}
      //       	var list = '';
      //       	$.ajax({
      //       		method: 'GET',
      //       		url: '',
      //       		data: {month: m, id: d},
      //       		success:function(data){
      //       			var i = 0;
      //       			for(object of data){
      //       				var p = object.present == "yes" ? " Present" : " Absent";
      //       				var ic = object.present == "yes" ? " fa-check" : " fa-times";
      //       				$('#cust_name').text(object.name.charAt(0).toUpperCase() + object.name.slice(1));
      //       				$('#cust_phone').text(object.phone);

      //       				list += '<tr>'+
	     //        				'<td class="fit">'+ ++i +'</td>'+
						// 		'<td class="fit">'+ object.attendance_date +'</td>'+
	     //        				'<td><i class="fa '+ ic +' aria-hidden="true"> '+ p +'</i></td>'+
						// 		'</tr>';
      //       			}

      //       			$('#table_body').html(list);
      //       		},
      //       		error:function(xhr, status, errorMsg){
      //       			// alert('Invalid month provided!');
      //       		}
      //       	});
      //       });

      //       //attendace of customer
      //       $('#cus_id').on('click keyup',function(){
      //       	var d = $('#cus_id option:selected').val();
      //       	var list = '';
      //       	$.ajax({
      //       		method: 'GET',
      //       		url: '',
      //       		data: {id: d},
      //       		success:function(data){
      //       			var i = 0;
      //       			if(typeof data !== 'undefined' && data.length <= 0){
      //       				return;
      //       			}

      //       			for(object of data){
      //       				var p = object.present == "yes" ? " Present" : " Absent";
      //       				var ic = object.present == "yes" ? " fa-check" : " fa-times";
      //       				$('#cust_name').text(object.name.charAt(0).toUpperCase() + object.name.slice(1));
      //       				$('#cust_phone').text(object.phone);

      //       				list += '<tr>'+
	     //        				'<td class="fit">'+ ++i +'</td>'+
						// 		'<td class="fit">'+ object.attendance_date +'</td>'+
	     //        				'<td><i class="fa '+ ic +' aria-hidden="true"> '+ p +'</i></td>'+
						// 		'</tr>';
      //       			}

      //       			$('#table_body').html(list);
      //       		}
      //       	});
      //       });
		});

		jQuery(document).on('click', '.dropdown_item', function(){
			var $ = jQuery;
        	$('#fullname').val($(this).text());
        	$('#phone').val($(this).attr('data'));
        	// $('#dropdownMe').stopPropagation();	
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
			<div class="card">
				<div class="card-header">
					Customer Attendance
				</div>
				<div class="card-body">	
					<form action="{{ route('customer_attendance') }}" method="post" accept-charset="utf-8">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3" style="position: relative;">
									<label for="fullname">Name: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter full name" autocomplete="off">
									<ul class="dropdown_menu" id="dropdownMe"></ul>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="phone">Phone: <span class="text-danger text_size"><sup>*</sup></span></label>
									@error('phone') 
									    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
									@enderror
									<input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror " readonly>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3" style="position: relative;">
									<label for="attendance_date">Attendance Date: <span class="text-danger text_size"><sup>*</sup></span></label>
									<input type="date" name="attendance_date" id="attendance_date" class="form-control" placeholder="Enter attendance date" autocomplete="off">
								</div>
							</div>
						</div>				
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_3">Save</button>
						</div>
					</form>
				</div>
			</div>

			{{-- <div class="card">
				<div class="card-header">
					Attendance List
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-3">
							<div class="form-group">
								<select name="month" class="custom-select" id="month">
									<option selected disabled value="">Select Month</option>
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
						<div class="col-12 col-md-3">
							<div class="form-group">
								<select name="cus_id" class="custom-select" id="cus_id">
									<option selected disabled value="0">Select Member</option>
									@foreach ($customers as $element)
										<option value="{{ $element->id }}">{{ $element->name }}</option>
									@endforeach
								</select>
							</div>	
						</div>
					</div>

					<div class="table-responsive">
						<div class="resize_tab_width">
							<div class="d-flex justify-content-start bg-light">
								<div class="p-2 text-dark">
									<strong>Name: </strong><span id="cust_name"></span>
								</div>
								<div class="p-2 text-dark">
									<strong>Phone: </strong><span id="cust_phone"></span>
								</div>
							</div>
							<table class="table table-striped table-hover table-bordered" id=""> 
								<thead>
									<tr>
										<th class="fit">Day</th>
										<th class="fit">Attendance date</th>
										<th class="fit">Status</th>
									</tr>
								</thead>
								<tbody id="table_body">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> --}}

			<div id="evo_calendar"></div>

		</div>
	</div>
@endsection