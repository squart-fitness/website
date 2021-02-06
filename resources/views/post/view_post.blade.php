@extends('parent')

@section('stylesheet')
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/css/jquery.dataTables.min.css')}}">

@endsection

@section('script_down')

	<script src={{asset('assets/libraries/js/jquery.dataTables.min.js')}}></script>
	<script>
		jQuery(document).ready( function () {
		    jQuery('#arrangeTable').DataTable();
		});
	</script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<div class="float_item align-self-center">
							<span>MY POSTS</span>
						</div>
						<div class="float_item">
							<a href="{{route('make_post')}}"><button class="btn btn-secondary">Make Post</button></a>
						</div>
					</div>
				</div>
				<div class="card-body">	
					<table class="table table-striped table-hover table-bordered" id="arrangeTable"> 
						<thead>
							<tr>
								<th>Title</th>
								<th>Post</th>
								<th>Email</th>
								<th>Package</th>
								<th>Address</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna </td>
								<td>Active</td>
							</tr>
							<tr>
								<td>ata</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Inactive</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Inactive</td>
							</tr>
							<tr>
								<td>data</td>
								<td>8541201254</td>
								<td>test@gmail.com</td>
								<td>Monthly</td>
								<td>Siddharth nagar jagdeo path bailey road patna</td>
								<td>Active</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection