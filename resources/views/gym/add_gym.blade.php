<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Squart</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

   
    <link rel="stylesheet" href={{asset("assets/libraries/css/bootstrap4.5.2.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/font-awesome.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/themify-icons.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/pe-icon-7-stroke.min.css")}}>

    <link rel="stylesheet" href={{asset("assets/css/style.css")}}>
    

   <style>
       /*CREATED BY ME*/
        .btn_size_1{
            padding-left: 10px;
            padding-right: 10px;
        }

        .btn_size_2{
            padding-left: 20px;
            padding-right: 20px;
        }

        .btn_size_3{
            padding-left: 30px;
            padding-right: 30px;
        }

        .btn_size_4{
            padding-left: 50px;
            padding-right: 50px;
        }

        .text_size{
            font-size: 16px;
        }

        .font_modify{
            font-size: 14px;
            /*font-family: sans-serif;*/
        }

        .content{
            padding-top: 0.5em;
            padding-bottom: 2em;
        }

        .float_item{
            padding-left: 10px;
            padding-right: 10px;
        }

        .float_item span{
            font-size: 18px;
        }

        .form-control{
            border-radius: 0 !important;
        }

        .form-control:focus{
            border-color: #ff0000;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 2px rgba(255, 0, 0, 0.6);
        }

        .form-group label{
            font-family: sans-serif;
            font-size: 14px !important;
        }

        .form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            font-size: 14px;
        }
        .form-control::-moz-placeholder { /* Firefox 19+ */
            font-size: 14px;
        }
        .form-control:-ms-input-placeholder { /* IE 10+ */
            font-size: 14px;
        }
        .form-control:-moz-placeholder { /* Firefox 18- */
            font-size: 14px;
        }

        .input_group_text_modified{
            font-size: 14px;
            padding-left: 0.5em;
            padding-right: 0.5em;
        }

        @media(max-width: 768px){
            .content{
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>
    
</head>

<body>
    
    <div class="container">
    	<div class="content">
			<div class="animated fadeIn">
				@if (Session::has('not_added'))
	                <div class="alert alert-danger">
	                    {{ Session::get('not_added') }}
	                </div>
	            @endif

	            @if (Session::has('msg'))
					<div class="alert alert-primary">
					   {!! Session::get('msg') !!}			
					</div>
				@endif

				<div class="card">
					<div class="card-header">
						ADD GYM
					</div>
					<div class="card-body">	
						<form action="{{ route('add_gym') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group mb-3">
										<label for="gymname">GYM Name: <span class="text-danger text_size"><sup>*</sup></span></label>

										@error('gymname') 
										    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
										@enderror
										<input type="text" name="gymname" id="gymname" class="form-control @error('gymname') is-invalid @enderror" placeholder="Enter GYM name" value="{{ old('gymname') }}">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group mb-3">
                                        <label for="gymemail">GYM Email: <span class="text-danger text_size"><sup>*</sup></span></label>

                                        @error('gymemail') 
                                            <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                        @enderror
                                        <input type="email" name="gymemail" id="gymemail" class="form-control @error('gymemail') is-invalid @enderror" placeholder="Enter GYM email id" value="{{ old('gymemail') }}">
                                    </div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="gymphone">GYM Phone: <span class="text-danger text_size"><sup>*</sup></span></label>

                                        @error('gymphone') 
                                            <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                        @enderror
                                        <input type="number" name="gymphone" id="gymphone" class="form-control @error('gymphone') is-invalid @enderror" placeholder="Enter GYM mobile number" value="{{ old('gymphone') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="gym_another_phone">Another Phone:(Optional)</label>

                                        @error('gym_another_phone') 
                                            <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                        @enderror
                                        <input type="number" name="gym_another_phone" id="gym_another_phone" class="form-control @error('gym_another_phone') is-invalid @enderror" placeholder="Enter another mobile number" value="{{ old('gym_another_phone') }}">
                                    </div>
									
								</div>                                
							</div>
							<hr>

                            <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="state">State: <span class="text-danger text_size"><sup>*</sup></span></label>

                                    @error('state') 
                                        <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="Enter state">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="city">City: <span class="text-danger text_size"><sup>*</sup></span></label>

                                    @error('city') 
                                        <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="Enter city">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="pincode">Pincode: <span class="text-danger text_size"><sup>*</sup></span></label>

                                    @error('pincode') 
                                        <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="pincode" id="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" placeholder="Enter pincode">
                                </div>
                            </div>

                        </div>
							<div class="form-group mb-2">
								<label for="address">Address: <span class="text-danger text_size"><sup>*</sup></span></label>

								@error('address') 
								    <div class="alert alert-danger" style="padding: 0;">{{ $message }}</div>
								@enderror
								<textarea type="text" rows="4" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ old('address') }}</textarea>
							</div>				
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Save</button>
							</div>
						</form>


						
					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- Scripts -->
    <script src={{asset("assets/libraries/js/jquery3.5.1.min.js")}}></script>
    <script src={{asset("assets/libraries/js/popper.min.js")}}></script>
    <script src={{asset("assets/libraries/js/bootstrap4.5.2.min.js")}}></script>
    <script src={{asset("assets/libraries/js/jquery.matchHeight.min.js")}}></script>
    <script src={{asset("assets/js/main.js")}}></script>

    {{-- laravel ajax setup --}}
    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>   
</body>
</html>
