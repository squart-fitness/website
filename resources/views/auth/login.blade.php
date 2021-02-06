@extends('out-master')

@section('stylesheet')
    <!-- font-awesome icons -->
    <link href="{{asset('assets/libraries/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!--stylesheets-->
    <link href="{{asset('assets/css/login_style.css')}}" rel='stylesheet' type='text/css' media="all">
    <!--//style sheet end here-->
    <link href="//fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
@endsection

@section('content')
    <h1 class="error">Squart Login</h1>
    <div class="w3layouts-two-grids">
        <div class="mid-class">
            <div class="txt-left-side">
                <h2> Login Here </h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-left-to-w3l">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <input type="email" name="email" placeholder="Email" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l ">

                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" placeholder="Password" required="">
                        <div class="clear"></div>
                    </div>
                    <div class="main-two-w3ls">
                        <div class="left-side-forget pl-1">
                            <input type="checkbox" class="checked" name="remember">
                            <span class="ml-2 align-top" style="color: #fff; font-size: 13px;">REMEMBER ME</span>
                        </div>
                        <div class="right-side-forget">
                            <a href="{{ route('password.request') }}" class="for">Forgot password...?</a>
                        </div>
                    </div>
                    <div class="btnn">
                        <button type="submit">Login </button>
                    </div>
                </form>
                <div class="w3layouts_more-buttn">
                    <h3 class="mt-2">Don't Have an account..? </h3>
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg mt-1" style="color: #000;">Register Here
                        </a>
                   
                </div>

            </div>
            <div class="img-right-side">
                <h3>Welcome To Squart</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget</p>
                <img src="{{asset('assets/images/training_girl.png')}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
@endsection