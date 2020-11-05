<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1604075788/icons/loder_h2qnck.webp">

    <!-- CSS here -->
    <link rel="stylesheet" defer  href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" integrity="sha512-GqP/pjlymwlPb6Vd7KmT5YbapvowpteRq9ffvufiXYZp0YpMTtR9tI6/v3U3hFi1N9MQmXum/yBfELxoY+S1Mw==" crossorigin="anonymous" />
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" />
    {{-- <link rel="stylesheet" href="/assets/css/flaticon.css"> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/progressbar_barfiller.css"> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/gijgo.css"> --}}
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.6.2/animate.min.css" integrity="sha512-HamjnVxTT+zKHJE1w1T2EDHSVvUlFwKgj71I65H73uirwaaAc7gJqfh2jXvGdzTgXvggQzWx5rjRIX6Uf3YCBg==" crossorigin="anonymous" />
    {{-- <link rel="stylesheet"  href="/assets/css/animated-headline.css"> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/magnific-popup.css"> --}}
    {{-- <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css" integrity="sha512-ykRBEJhyZ+B/BIJcBuOyUoIxh0OfdICfHPnPfBy7eIiyJv536ojTCsgX8aqrLQ9VJZHGz4tvYyzOM0lkgmQZGw==" crossorigin="anonymous" /> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/themify-icons.css"> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/slick.css"> --}}
    {{-- <link rel="stylesheet"  href="/assets/css/nice-select.css"> --}}
    <link rel="stylesheet" defer href="/assets/css/style.css">
    @stack('page-css')
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header ">
                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="/"><img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1604075952/page-image/logo2_l0iqkt.webp" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10">
                                <div class="menu-wrapper d-flex align-items-center justify-content-end">
                                    <!-- Main-menu -->
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">                                                                                          
                                                <li class="active" ><a href="/">Home</a></li>
                                                <li><a href="#course-section">Courses</a></li>
                                                <li><a href="#about-section">About</a></li>
                                                <!-- Button -->
                                                <li class="button-header margin-left "><a href="{{ route('register') }}" class="btn">Join</a></li>
                                                <li class="button-header"><a href="{{ route('login') }}" class="btn btn3">Log in</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div> 
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
      @yield('content')
    </main>
    <footer>
     <div class="footer-wrappper footer-bg">
        <!-- footer-bottom area -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-center">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                  Copyright &copy; {{ date('Y') }} All rights reserved</a>
                                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Footer End-->
      </div>
  </footer> 
  

<!-- Jquery, Popper, Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ==" crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script> --}}

<!-- Jquery Mobile Menu -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js" integrity="sha512-FmCXNJaXWw1fc3G8zO3WdwR2N23YTWDFDTM3uretxVIbZ7lvnjHkciW4zy6JGvnrgjkcNEk8UNtdGTLs2GExAw==" crossorigin="anonymous"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js" integrity="sha512-lo4YgiwkxsVIJ5mex2b+VHUKlInSK2pFtkGFRzHsAL64/ZO5vaiCPmdGP3qZq1h9MzZzghrpDP336ScWugUMTg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
<script src="/assets/js/main.js"></script>
<!-- One Page, Animated-HeadLin -->
{{-- <script src="/assets/js/wow.min.js"></script> --}}
{{-- <script src="/assets/js/animated.headline.js"></script> --}}
{{-- <script src="/assets/js/jquery.magnific-popup.js"></script> --}}

<!-- Date Picker -->
{{-- <script src="/assets/js/gijgo.min.js"></script> --}}
<!-- Nice-select, sticky -->

{{-- <script src="/assets/js/jquery.sticky.js"></script> --}}
<!-- Progress -->
{{-- <script src="/assets/js/jquery.barfiller.js"></script> --}}

<!-- counter , waypoint,Hover Direction -->
{{-- <script src="/assets/js/jquery.counterup.min.js"></script> --}}
{{-- <script src="/assets/js/waypoints.min.js"></script> --}}
{{-- <script src="/assets/js/jquery.countdown.min.js"></script> --}}
{{-- <script src="/assets/js/hover-direction-snake.min.js"></script> --}}



@stack('page-scripts')
</body>
</html>