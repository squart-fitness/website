@extends('parent')

@section('stylesheet')
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

	</style>
@endsection

@section('script_down')
	<script src="{{asset('assets/libraries/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/libraries/ckeditor/adapters/jquery.js')}}"></script>
    <script>
    	var $ = jQuery;
    	jQuery(document).ready(function(){
	        jQuery('textarea').ckeditor();

	        //delete a customer
		    $('.delete').on('click', function(){
		    	var link = $(this).attr('data-link');
		    	$('#deleteModal form').attr('action', link);
		    });
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
					<span>MAKE DIET PLAN</span>
				</div>
				<div class="float_item">
					<nav aria-label="breadcrumb">						
		  				<ol class="breadcrumb">		  					
		    				<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		    				<li class="breadcrumb-item active" aria-current="page">Diet plan</li>
		  				</ol>
					</nav>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<form action="{{ route('create_diet_plan') }}" method="post" accept-charset="utf-8">
						@csrf
						
						<div class="form-group">
							<label for="title">Title: <span class="text-danger text_size"><sup>*</sup></span></label>

							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Add title" value="{{ old('title') }}">
							@error('title') 
							    <div class="invalid-feedback font-weight-bold" style="padding: 0;">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="plan">Diet plan: <span class="text-danger text_size"><sup>*</sup></span></label>

							<textarea name="plan" class="form-control @error('plan') is-invalid @enderror">{{ old('plan') }}</textarea>
							@error('plan') 
							    <div class="invalid-feedback font-weight-bold" style="padding: 0;">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn_size_3">Save</button>
						</div>
					</form>
				</div>
			</div>

			<div class="row">

				@foreach ($diets as $element)
					<div class="col-12 col-md-6">
						<div class="card">
							<div class="card-header">

								<div class="d-flex justify-content-between">
									<div class="float_item">
										<span>{{ $element->title }}</span>
									</div>
									<div class="float_item">
										<a data-s="{{ $element->status }}" data-d="{{ $element->id }}" class="status">{!! $element->status == 1 ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<i class="fa fa-times-circle" aria-hidden="true"></i>' !!}</a>

										<a data-target="#deleteModal" data-toggle="modal" data-link="{{ route('delete_diet', ['d' => $element->id]) }}" class="delete ml-4"><i class="fa fa-trash" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<p>
									{!! $element->diet_description !!}
								</p>
							
							</div>
						</div>
					</div>
				@endforeach

			</div>


		</div>
	</div>

@endsection