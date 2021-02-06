@extends('parent')

@section('script_down')
	<script src="{{asset('assets/libraries/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/libraries/ckeditor/adapters/jquery.js')}}"></script>
    <script>
    	jQuery(document).ready(function(){
	        jQuery('textarea').ckeditor();
    	});

    </script>

@endsection

@section('content')

	<div class="content">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-header">
					<span>MAKE WORKOUT PLAN</span>
				</div>
				<div class="card-body">
					<form action="#" method="get" accept-charset="utf-8">
						<div class="form-group">
							<label for="title">Title:</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Add title">
						</div>
						<div class="form-group">
							<label for="plan">Workout plan:</label>
							<textarea name="plan" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_3">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection