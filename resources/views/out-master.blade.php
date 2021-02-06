<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Squart - Gym Management Application</title>
    <meta content="squart - gym management software for customers" name="descriptison" />
    <meta content="gym,software,customer,management" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Krub:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link
      href="assets/vendor/owl.carousel/assets/owl.carousel.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/index_style.css" rel="stylesheet" />
    <style>
      .logo img{
          height: 35x;
          width: 35px;
      }
      .logo span{
          font-size: 26px;
          font-family: 'Poppins', sans-serif;
          font-weight: 400;
      }
      .contact_form{
          box-shadow: 0 0 30px rgba(214, 215, 216, 0.6);
          padding: 30px;
          background: #fff;
      }

      @media (max-width: 992px){
        #header{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }
      }
    </style>

    @yield('stylesheet')
  </head>

  <body>
    <!-- ======= Header ======= -->
    <header id="header">
      <div class="container d-flex align-items-center">
        <h1 class="logo mr-auto"><a href="{{ route('index') }}"><img src="{{asset('assets/img/squart_logo.png')}}" alt="logo"><span class="text-dark ml-2">Squart</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav class="nav-menu d-none d-lg-block">
          <ul>
            <li class="active"><a href="{{ route('index') }}">Home</a></li>
            <li><a href="{{ route('index') }}#about">About</a></li>
            <li><a href="{{ route('index') }}#features">Features</a></li>
            <li><a href="{{ route('index') }}#services">Services</a></li>
            <li><a href="{{ route('index') }}#pricing">Pricing</a></li>
            <li><a href="{{ route('index') }}#contact">Contact</a></li>

            @guest
                @if (!Route::is('register'))
                    <li><a href="{{ route('register') }}">Register</a></li>
                @endif
            @endguest

          </ul>
        </nav>
        <!-- .nav-menu -->
        @guest
            @if (!Route::is('login'))
                <a href="{{ route('login') }}" class="get-started-btn scrollto">Login</a>
            @endif
        @endguest

        @auth
            <a href="{{ route('dashboard') }}" class="get-started-btn scrollto">My Account</a>
        @endauth

      </div>
    </header>
    <!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">
      <div class="footer-top">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 footer-contact">
              <h1 class="logo mr-auto"><a href="{{ route('index') }}"><img src="{{asset('assets/img/squart_logo.png')}}" alt="logo"><span class="text-dark ml-2">Squart</span></a></h1>
              <p>
                Digha<br />
                Patna<br />
                Bihar, IN<br /><br />
                <strong>Phone:</strong> +91 8210760137<br />
                <strong>Email:</strong> contact@squart.in<br />
              </p>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
              <h4>Useful Links</h4>
              <ul>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">Home</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">About us</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">Services</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i>
                  <a href="#">Terms of service</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i>
                  <a href="#">Privacy policy</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="container d-md-flex py-4">
        <div class="mr-md-auto text-center text-md-left">
          <div class="copyright">
            &copy; Copyright <strong><span>squart.in</span></strong
            >. All Rights Reserved
          </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/index_main.js"></script>
  </body>
</html>