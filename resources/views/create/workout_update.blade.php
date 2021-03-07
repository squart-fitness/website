@extends('parent')

@section('script_down')
	<script src="{{asset('assets/libraries/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/libraries/ckeditor/adapters/jquery.js')}}"></script>
    <script>
    	var $ = jQuery;
    	jQuery(document).ready(function(){
	        jQuery('textarea').ckeditor();

    	});

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
					<span>Update Workout Plan</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item"><a href="{{ route('create_workout_plan') }}">Workout Plan</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Workout update</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<form action="{{ route('update_workout') }}" method="post" accept-charset="utf-8">
						@csrf
						
						<input type="hidden" name="d" value="{{ $workout->id }}">
						<div class="form-group">
							<label for="title">Title: <span class="text-danger text_size"><sup>*</sup></span></label>

							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Add title" value="{{ $workout->title }}">
							@error('title') 
							    <div class="invalid-feedback font-weight-bold" style="padding: 0;">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="plan">Diet plan: <span class="text-danger text_size"><sup>*</sup></span></label>

							<textarea name="workout_plan" class="form-control @error('workout_plan') is-invalid @enderror">{{ $workout->workout_description }}</textarea>
							@error('workout_plan') 
							    <div class="invalid-feedback font-weight-bold" style="padding: 0;">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_3">Update</button>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

@endsection