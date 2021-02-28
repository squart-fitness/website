<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Squart - Gym Management Application</title>
    <meta name="description" content="squart - gym management software for customers">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

   
    <link rel="stylesheet" href={{asset("assets/libraries/css/bootstrap4.5.2.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/font-awesome.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/themify-icons.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/pe-icon-7-stroke.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/pe-icon-7-stroke.min.css")}}>
    <link rel="stylesheet" type="text/css" href={{ asset('assets/libraries/parsley/parsley.css') }}>
    
    <link rel="stylesheet" href={{asset("assets/css/style.css")}}>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' />
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

    @yield('stylesheet')
    @yield('script_up')
    
</head>

<body>
    <!-- Left Panel -->
    @include('_panels.left_panel')
    <!-- /#left-panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        @include('_header.header')
        <!-- /#header -->

        <!-- Content -->
        @yield('content')
        <!-- /.content -->

        <div class="clearfix"></div>


        <!-- Modal to delete list item --->

        <div class="modal" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5 class="modal-title">Confirm password to delete</h5>
                        <hr>
                        <div class="delete_form">
                            <form action="#" method="post" accept-charset="utf-8">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>        
                    </div>
                </div>
            </div>
        </div>


        <!--- Modal to delete list item end -->


        <!-- Footer -->
        @include('_footer.footer')
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src={{asset("assets/libraries/js/jquery3.5.1.min.js")}}></script>
    <script src={{asset("assets/libraries/js/popper.min.js")}}></script>
    <script src={{asset("assets/libraries/js/bootstrap4.5.2.min.js")}}></script>
    <script src={{asset("assets/libraries/js/jquery.matchHeight.min.js")}}></script>
    <script src={{asset("assets/js/main.js")}}></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libraries/parsley/parsley.min.js') }}">

    {{-- laravel ajax setup --}}
    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery(document).ready(function(){
            var $ = jQuery;
            $('.nav .navbar-nav').on('click keyup', function(){
                console.log($(this));
            });

            $('#popover').popover();   
        });
    </script>
    @yield('script_down')
   
</body>
</html>
