<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>TechShop</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('customer/css/bootstrap.min.css') }}" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('customer/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('customer/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('customer/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('customer/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('customer/css/style.css') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> techshop@email.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i> Greenwich Viet Nam</a></li>
                </ul>
                <ul class="header-links pull-right">
                    <li><a href="{{ url('admin') }}">
                            @if (Session::has('user_id'))
                            @else
                                <i class="fa fa-id-card"></i>Admin
                            @endif
                        </a></li>
                    <li><a href="{{ url('admin')}}"><i class="fa fa-user-o"></i>
                            @if (Session::has('user_id'))
                                Xin chào {{ session('user_name') }}
                                {{-- <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();

                            document.getElementById('logout-form').submit();">Đăng
                            xuất</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}
                    <li><a href="@if (session('user_role') == 1)
                        {{ route('dashboard')  }}
                    @else
                        {{ route('profile', session('user_id'))  }}
                    @endif">Your Profile</a></li>
                    <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                @else
                    Đăng nhập
                    @endif
                    </a></li>
                </ul>
            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="{{ route('home_page') }}" class="logo">
                                <img src="{{ asset('customer') }}/img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form>
                                <input class="input" placeholder="Tìm kiếm ở đây">
                                <button class="search-btn">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            <div>
                                <a href="{{ route('home_page') }}">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Yêu thích</span>
                                    <div class="qty">2</div>
                                </a>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty">3</div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list">
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="{{ asset('customer') }}/img/product01.png" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">product name goes here</a>
                                                </h3>
                                                <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                            </div>
                                            <button class="delete"><i class="fa fa-close"></i></button>
                                        </div>

                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="{{ asset('customer') }}/img/product02.png" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">product name goes here</a>
                                                </h3>
                                                <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                                            </div>
                                            <button class="delete"><i class="fa fa-close"></i></button>
                                        </div>
                                    </div>
                                    <div class="cart-summary">
                                        <p>3 sản phẩm trong giỏ hàng</p>
                                        <h5>Tổng cộng: $2940.00</h5>
                                    </div>
                                    <div class="cart-btns">
                                        <a href="#">Xem giỏ hàng</a>
                                        <a href="#">Thanh toán <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="#">Trang chủ</a></li>
                    @foreach ($product_cats as $cat)
                        <li><a href="{{ route('category', $cat->name) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->

    @yield('content')

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng ký để nhận thông tin <strong>MỚI NHẤT</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Nhập email của bạn tại đây">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Đăng ký</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->

    
    <!-- FOOTER -->
    <footer id="footer">
        <!-- top footer -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-5 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Về chúng tôi</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Danh mục</h3>
                            <ul class="footer-links">
                                @foreach ($product_cats as $cat)
                                    <li><a href="{{ route('category', $cat->name) }}">{{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Thông tin</h3>
                            <ul class="footer-links">
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Hỗ trợ</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Chính sách đổi trả</a></li>
                                <li><a href="#">Điều khoản và dịch vụ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->

        <!-- bottom footer -->
        <div id="bottom-footer" class="section">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('customer/js/jquery.min.js') }}"></script>
    <script src="{{ asset('customer/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('customer/js/slick.min.js') }}"></script>
    <script src="{{ asset('customer/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('customer/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('customer/js/main.js') }}"></script>

</body>

</html>
