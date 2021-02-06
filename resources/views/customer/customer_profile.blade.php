@extends('parent')

@section('stylesheet')

	<style>
		.bg_color_3{
			background-color: #4A4A4A;
			color: #fff;
		}
		.right-panel{
			/*background-color: #ffffff !important;*/
		}
		.right-panel header.header{
			border: 0;
			box-shadow: 0 1px 3px #343a40;
			background-color: #343a40;
		}
		.right-panel .navbar-header, aside.left-panel, .navbar {
			background-color: #343a40;
		}
		
		.navbar .navbar-nav li > a, .navbar .navbar-nav li > a .menu-icon{
			color: #fff;
		}

		.content{
			padding-bottom: 70px;
			background-color: #6A6A6A;
			color: #fff;
		}
		.table{
			color: #fff;
		}
		.table td.fit, 
		.table th.fit {
		    white-space: nowrap;
		    width: 1%;
		}
		.resize_tab_width{
			width: 73vw;
		}
		.profile_card{
			padding-top: 1em;
			border-radius: 10px;
			box-shadow: 0 0 4px #1B1B1B!important;
			background-color: #111319;
		}
		.card-img-top{
			height: 130px;
			width: 130px;
			border-radius: 50%;
		}
		.card-title{
			text-align: center;
			color: #E4DA16;
			font-size: 18px;
			font-family: sans-serif;
			font-weight: 550;
		}
		.card, .card ul li{
			 background-color: transparent !important;
			 padding-left: 0;
			 padding-right: 0;
		}
		.card ul li{
			color: #ffffff;
			font-weight: 500;
			font-family: sans-serif;
			font-size: 14px;
		}
		.card .custom_btn{
			margin-bottom: 20px;
		}
		.card .custom_btn button{
			font-weight: 600;
		}
		.card .card-header{
			background-color: #343a40;
			color: #fff;
		}

		.profile_card_feature .float_item h3{
			font-size: 16px;
			font-weight: 500;
			font-family: sans-serif;
			color: #E1DFF6;
		}
		.profile_card_feature .float_item h4{
			font-size: 14px;
			font-weight: 500;
			font-family: sans-serif;
			font-style: italic;
		}

		.profile_card_feature .float_item button{
			font-size: 14px;
			font-weight: 600;
			font-family: sans-serif;
		}

		.navbar .navbar-nav li.menu-item-has-children .sub-menu{
			background-color: transparent;
		}
		.full_image{
			display: none;
			position: absolute;
			background-color: rgba(0,0,0,0.4);
			height: 150%;
			width: 100%;
			top: 0;
			left: 0;
			z-index: 3;
		}
		.full_image img{
		    width: auto;
		    height: fit-content;
		    vertical-align: middle;
		    transform: translateY(20%);
		    z-index: 1000;
		}
		/*.pagination_link{
			margin-top: 20px; 
		}
		.pagination_link span{
			background-color: transparent !important;
		}
		.pagination_link a{
			color: #fff ;
			background-color: #6c757d!important;
		}
		.pagination_link a:hover{
			background-color: #f8f9fa!important;
			color: #000;
		}*/
	</style>
@endsection

@section('script_down')

	<script>
		jQuery(document).ready(function(){
			var $ = jQuery;
			$('.c_image_wrapper').on('click', function(event){
		    	var img_url = $('.c_image_wrapper img');
		    	$('.full_image').css('display', 'block');

		    	var set_image = $('.full_image img');
		    	set_image.attr('src', event.target.currentSrc);
		    	console.log(event.target.currentSrc);
		    });

		    $('.full_image').on('click', function(){
		    	$(this).css('display', 'none');
		    });
		});
	</script>

@endsection

@section('content')

	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4">
					<div class="profile_card">
						<div class="card mb-0">
							<div class="d-flex justify-content-center">
								<div class="c_image_wrapper">
									@if ($profile->customer_image)
										<img src="{{ asset('assets/c_images/'.$profile->customer_image) }}" class="card-img-top" alt="customer image">
									@else
									  	<img class="card-img-top" src="{{ asset('assets/images/avatar/cool_avatar_boy.png') }}" alt="Card image">
									@endif
								</div>
							</div>
						  	<div class="card-body pt-2">
						    	<h4 class="card-title mb-4">{{ ucfirst($profile->name) }}</h4>
						    	
						    	<ul class="list-group list-group-flush mb-5">
						    		<li class="list-group-item">
						    			<div class="d-flex justify-content-between">
						    				<span class="card_text">Member ID:</span>
						    				<span class="card_text">{{ $profile->username }}</span>
						    			</div>
						    		</li>
						    		<li class="list-group-item">
						    			<div class="d-flex justify-content-between">
						    				<span class="card_text">Package Owned:</span>
						    				<span class="card_text">
						    						{{ ucfirst($profile->package) }}
						    				</span>
						    			</div>
						    		</li>
						    		<li class="list-group-item">
						    			<div class="d-flex justify-content-between">
						    				<span class="card_text">Package Price:</span>
						    				<span class="card_text">Rs: {{ $profile->fee }}</span>
						    			</div>
						    		</li>
						    		<li class="list-group-item">
						    			<div class="d-flex justify-content-between">
						    				<span class="card_text">Due Amount:</span>
						    				<span class="card_text">Rs: 
						    					@php
						    						$result = App\Models\Payment::select('due_amount')->where(['gym_id'=>auth()->user()->id, 'customer_id' => $profile->id])->latest()->first();

						    						if(isset($result)){
						    							echo $result->due_amount;
						    						}
						    					@endphp
						    				</span>
						    			</div>
						    		</li>

						    	</ul>

						    	<div class="custom_btn">
						    		<button type="button" class="btn btn-block btn-warning"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;Attendance</button>
							    	<a href="#payment" class="btn btn-block btn-warning"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>&nbsp;&nbsp;Payment</a>
						    	</div>
						  	</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-8">
					<div class="profile_card_feature">
						<div class="top_feature mt-3">
							<div class="d-flex justify-content-between">
								<div class="float_item">
									<h3>Membership Goal</h3>
									<h4>{{ ucfirst($profile->goal) }}</h4>
								</div>
								<div class="float_item">
									<h3>Fitness Freak</h3>
								</div>
							</div>
						</div>
						<hr>

						<div class="event_buttons">
							<div class="d-flex justify-content-between">
								<div class="float_item">
									<button type="button" class="btn btn-info">UPGRADE</button>
								</div>
								<div class="float_item">
									<button type="button" class="btn btn-info">FREEZE</button>
								</div>
								<div class="float_item">
									<button type="button" class="btn btn-info">ASSIGN PT</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- payment details of a customer --}}
		    <div class="row">
				<div id="payment" class="pt-5">
					<div class="card mb-5">
						<div class="card-header">
							<div class="d-flex justify-content-between">
								<div class="float_item align-self-center">
									<span>PAYMENT DETAILS</span>
								</div>
								<div class="float_item">
									<a href="{{route('customer_payment')}}"><button class="btn btn-secondary">Make payment</button></a>
								</div>
							</div>
						</div>
						<div class="card-body bg_color_3">	
							<div class="row">
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
							</div>
							<div class="table-responsive">
								<div class="resize_tab_width">
									<table class="table table-striped table-bordered" id="arrangeTable"> 
										<thead>
											<tr>
												<th class="fit">Serial no</th>
												<th class="fit">Total amount</th>
												<th class="fit">Paid amount</th>
												<th class="fit">Due amount</th>
												<th class="fit">Purpose</th>
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
											@foreach ($pay as $element)
												<tr>
													<td class="fit">{{ ++$i }}</td>
													<td class="fit">{{ $element->total_amount }}</td>
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
			<!-- end of payment details -->

			<!---  show full image of members on click in the division element -->
			<div class="full_image">
				<div class="d-flex justify-content-center">
					<img src="{{ asset('assets/images/avatar/c_avatar.png') }}" alt="member full image">					
				</div>
			</div>
		</div>
	</div>

@endsection