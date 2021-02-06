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
					TYPES OF MACHINES
				</div>
				<div class="card-body">
					<form action="#" method="post" class="form-inline">
						<div class="form-group">
							<label for="machine" class="mr-2">Machine name:</label>
							<input type="text" name="machine" class="form-control mr-2" id="machine" placeholder="Type machine name">
							<button type="submit" class="btn btn-primary">Add Machine</button>
						</div>
					</form>	
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					MACHINE LIST
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-6">
							<table class="table table-striped table-hover table-bordered" id="arrangeTable">
								<thead>
									<tr>
										<th>Serial number</th>
										<th>Machine name</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Bench press</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Barbell</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Shoulder press</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Smith</td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection