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

		#member_view{
			width: 100%;
			height: 44px;
			margin-bottom: 20px;
			padding: 10px;
			font-size: 16px;
			background-color: #efefef;
			border: 1px solid #d4d4d4;
		}

		.workout_title{
			background-color: #d1d1d1;
			font-size: 18px;
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

			 $('.select_item').click(function(){
			 	$('#member_view').text($(this).text());
			 	$('#member_id').val($(this).attr('data'));
			 });
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
					<span>WORKOUT PLAN ASSIGNMENT</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Assign workout plan</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<div class="dropdown">
							  	{{-- <button onclick="myFunction()" class="dropbtn">Select Member</button> --}}
							    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
							  	<div id="myDropdown" class="dropdown-content">
								    @foreach ($customers as $element)
								    	<a class="select_item" data="{{ $element->id }}">{{ ucfirst($element->name) }}&nbsp;&nbsp;&nbsp;&nbsp;<small>{{ $element->phone }}</small></a>
								    @endforeach
							  	</div>
							</div>
						</div>
						<div class="col-6">
							<div class="container-fluid">
								<div id="member_view"></div>
								<form action="#" method="post" accept-charset="utf-8">
									@csrf

									<input type="hidden" id="member_id" name="member_id">
									<h4 class="workout_title">Workout plan list</h4>
									<div class="list-group">
										@foreach ($titles as $element)
											<div class="list-group-item">
												<input type="checkbox" name="workout[]" value="{{ $element->id }}">
												<label for="">{{ $element->title }}</label>
											</div>
										@endforeach
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