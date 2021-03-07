@extends('parent')

@section('stylesheet')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

	<style>
		.table td.fit, 
		.table th.fit {
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

		.view_card{
			height: 400px;
		}

		/* search dropdown styles starts */


		.dropbtn {
		  background-color: #4CAF50;
		  color: white;
		  padding: 10px;
		  font-size: 16px;
		  min-width: 264px;
		  border: none;
		  cursor: pointer;
		}

		.dropbtn:hover, .dropbtn:focus {
		  background-color: #3e8e41;
		}

		#myInput {
		  box-sizing: border-box;
		  background-image: url('searchicon.png');
		  background-position: 14px 12px;
		  background-repeat: no-repeat;
		  font-size: 16px;
		  padding: 14px 20px 12px 15px;
		  border: 1px solid #ddd;
		  min-width: 264px;
		  height: 44px;
		}

		#myInput:focus {outline: 3px solid #ddd;}

		.dropdown {
		  position: relative;
		  display: inline-block;
		}

		.dropdown-content {
		  display: block;
		  position: absolute;
		  background-color: #f6f6f6;
		  min-width: 230px;
		  overflow: auto;
		  border: 1px solid #ddd;
		  z-index: 1;
		  height: 300px;
		  overflow-y: scroll;
		}

		.dropdown-content a {
		  color: black;
		  padding: 12px 16px;
		  text-decoration: none;
		  display: block;
		  cursor: pointer;
		}

		.dropdown a:hover {background-color: #ddd;}

		.show {display: block;}

		/* search dorpdown styels ends */

		/* list view  */


		.view_title{
			background-color: #d1d1d140;
			font-size: 16px;
			font-family: sans-serif;
			padding: 10px;
			border-top-left-radius: 3px;
			border-top-right-radius: 3px;
		}

		.list-group-item{
			padding: 5px 15px;
			font-size: 14px;
			font-family: sans-serif;
		}

		.list-group-item label{
			margin-bottom: 0;
		}

		/* list view ends */

	</style>
@endsection

@section('script_down')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
	<script>
		var $ = jQuery;
		
		$(document).ready(function(){
			 $('.selectpicker').selectpicker();

			 $('.select_item').on('click',function(){
			 	$('#myInput').val($(this).text());
			 	var d = $(this).attr('data');
			 	$('#member_id').val(d);
			 	$.ajax({
			 		method: 'GET',
			 		url: '{{route('get_customer_batch')}}',
			 		data: {id: d},
			 		success:function(result){
			 			if(result !== null)
				 			$('#view_text').text(result.batch.charAt(0).toUpperCase() + result.batch.slice(1));
			 		}
			 	});
			 })
		});

		function myFunction() {
		  document.getElementById("myDropdown").classList.toggle("show");
		}

		function filterFunction() {
		  var input, filter, ul, li, a, i;
		  input = document.getElementById("myInput");
		  filter = input.value.toUpperCase();
		  div = document.getElementById("myDropdown");
		  a = div.getElementsByTagName("a");
		  for (i = 0; i < a.length; i++) {
		    txtValue = a[i].textContent || a[i].innerText;
		    if (txtValue.toUpperCase().indexOf(filter) > -1) {
		      a[i].style.display = "";
		    } else {
		      a[i].style.display = "none";
		    }
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

			<div class="d-flex justify-content-between font_modify">
				<div class="float_item align-self-center attach_to_body">
					<span>Change Batch</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('batch') }}">Batch</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Change batch</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card view_card">
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<div class="dropdown">
							    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
							  	<div id="myDropdown" class="dropdown-content">
								    @foreach ($customers as $element)
								    	<a class="select_item" data="{{ $element->id }}">{{ ucfirst($element->name) }}&nbsp;&nbsp;&nbsp;&nbsp;<small class="float-right">{{ $element->phone }}</small></a>
								    @endforeach
							  	</div>
							</div>
						</div>
						<div class="col-6">
							<div class="container-fluid">
								<form action="{{ route('assign_batch') }}" method="post" accept-charset="utf-8">
									@csrf

									<input type="hidden" id="member_id" name="member_id">
									@error('member_id') 
										<div class="alert alert-danger mb-0 p-0">{{ $message }}</div>
									@enderror
									<h5 class="view_title">Current batch: <span id="view_text"></span></h5>
									<div class="list-group">
										@error('batch') 
											<div class="alert alert-danger mb-0 p-0">{{ $message }}</div>
										@enderror
										<select name="batch" class="custom-select @error('batch') is-invalid @enderror">
											<option selected disabled>Select Batch</option>
                                            @foreach ($batches as $element)
                                            	<option value="{{$element->batch_name}}">{{ ucfirst($element->batch_name) }}</option>
                                            @endforeach
										</select>
									</div>
									<button type="submit" class="btn btn-primary btn-block mt-4">Submit</button>
								</form>
							</div>
						</div>
					</div>
					
				</div>
			</div>

		</div>
	</div>

@endsection