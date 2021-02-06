@extends('parent')


@section('content')

	<div class="content">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-header">
					CREATE LISTING
				</div>
				<div class="card-body">	
					<form action="#" method="get" accept-charset="utf-8">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="title">Title:</label>
									<input type="text" name="title" id="title" class="form-control" placeholder="Enter title">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="since">Working since (in years):</label>
									<input type="number" name="since" id="since" class="form-control" placeholder="Enter work experience">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="members-count">No of members:</label>
									<input type="number" name="members-count" id="members-count" class="form-control" placeholder="Enter number of active members">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="trainer-count">No of trainers:</label>
									<input type="number" name="trainer-count" id="trainer-count" class="form-control" placeholder="Enter number of trainers">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group md-3">
									<label for="package">Package detail:</label>
									<textarea type="text" name="package" id="package" class="form-control" placeholder="Enter package details"></textarea>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<label for="description">Description:</label>
									<textarea type="text" name="description" id="description" class="form-control" placeholder="Enter Description about gym"></textarea>
								</div>	
							</div>
						</div>

						<div class="form-group md-3">
							<label for="package">Profile image:</label>
							<input type="file" name="profile_image" class="form-control">
						</div>

						<hr>
						<h4 class="mb-2 text-secondary">Additional Details:</h4>
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<input type="checkbox" name="machine_types">
									<label>Show machine name</label>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-3">
									<input type="checkbox" name="offer">
									<label>Show offer</label>
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