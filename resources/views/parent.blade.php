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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

   
    <link rel="stylesheet" href={{asset("assets/libraries/css/bootstrap4.5.2.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/font-awesome.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/themify-icons.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/pe-icon-7-stroke.min.css")}}>
    <link rel="stylesheet" href={{asset("assets/libraries/css/pe-icon-7-stroke.min.css")}}>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libraries/parsley/parsley.css') }}">

    <link rel="stylesheet" href={{asset("assets/css/style.css")}}>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>

   <style>
       
        /*#weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
*/
        /*CREATED BY ME*/
        
        .popover{
            background-color: #000;
        }

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

        .form-control:focus, .custom-select:focus, .custom-switch:focus{
            border-color: #4f86e3;
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

        .navbar-header img{
            height: 28px;
            width: 28px;
        }
        /*.top-right{
            position: relative;
        }*/
        .header .header_middle{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .header .title_name{
            font-family: sans-serif;
            font-size: 26px;
            font-weight: 600;
            color: #313a3d;
        }

        #menus_list{
            padding: 15px 15px 0 15px;
            width: 300px;
            background: #e3e3e3;
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
            .top-right{
                padding: 0px;
            }
        }

        @media(max-width: 992px){
            .header .header_middle{
                display: none;
            }
        }
    </style>

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
