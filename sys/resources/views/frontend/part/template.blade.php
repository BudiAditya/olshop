<!DOCTYPE html>
<html>
<head>
    <title> {{ config('setting.NamaToko') }} </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/fonts/sb-bistro/sb-bistro.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/fonts/font-awesome/font-awesome.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/o2system-ui/o2system-ui.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/owl-carousel/owl-carousel.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/cloudzoom/cloudzoom.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/thumbelina/thumbelina.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/bootstrap-touchspin/bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/css/theme.css') }}">
    @stack('css')

</head>
<body>
    <div class="page-header">
        <!--=============== Navbar ===============-->
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-transparent" id="page-navigation">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="{{ route('index') }}" class="navbar-brand">
                    <img src="{{ asset('img/logo.png') }}" alt="">
                </a>

                <!-- Toggle Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarcollapse">
                    <!-- Navbar Menu -->
                    <ul class="navbar-nav ml-auto">
                    @guest
                        @if (Route::has('register'))
                         <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                        </li>                         
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar-header"><img src="{{ asset('img') }}/{{ Auth::user()->gambar ? Auth::user()->gambar : 'avatar.jpg' }}"></div> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->is_admin==1)
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('transaksi') }}">Transactions History</a>
                                <a class="dropdown-item" href="{{ route('pengaturan') }}">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                                >
                                    {{ __('Logout') }}
                                </a>
                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                        <li class="nav-item">
                            <a href="{{ route('shop') }}" class="nav-link">Shop</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php $total = 0; $total_qty =0; ?>
                                @guest
                                    @if(session('cart'))                                
                                    <?php
                                        foreach(session('cart') as $id => $product){
                                            $total_qty += $product['quantity'];
                                        }
                                    ?>
                                    @endif
                                @else
                                    <?php
                                        $carts = App\Model\Carts::where('customer_id', Auth()->id())->get();
                                        foreach($carts as $cart){
                                            $total_qty += $cart->quantity;
                                        }
                                    ?>
                                @endguest

                                <i class="fa fa-shopping-basket"></i> <span class="badge badge-primary">{{$total_qty}}</span>
                            </a>
                            <div class="dropdown-menu shopping-cart">
                                <ul>
                                    <li>
                                        <div class="drop-title">Your Cart</div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-list">

                                        @guest

                                            @if(session('cart'))
                                            @foreach(session('cart') as $id => $product)
                                            <?php  $total += $product['harga'] * $product['quantity']; ?>


                                                <div class="media">
                                                    <img class="d-flex mr-3" src="{{ asset('frontend/img/') }}/{{$product['gambar']}}" width="60">
                                                    <div class="media-body">
                                                        <h5><a href="javascript:void(0)">{{$product['nama']}}</a></h5>
                                                        <p class="price">
                                                            <span class="discount text-muted">Rp. 80.000</span>
                                                            <span>Rp. {{$product['harga'] * $product['quantity']}}</span>
                                                        </p>
                                                        <p class="text-muted">Qty: {{$product['quantity']}}</p>
                                                    </div>
                                                </div>

                                            @endforeach
                                            @endif

                                        @else
                                            <?php $carts = App\Model\Carts::where('customer_id', Auth()->id())->get(); ?>
                                            @foreach($carts as $cart)
                                            <?php  $total += $cart->Produk->harga_jual * $cart->quantity; ?>


                                                <div class="media">
                                                    <img class="d-flex mr-3" src="{{ asset('frontend/img/') }}/{{$cart->Produk->gambar}}" width="60">
                                                    <div class="media-body">
                                                        <h5><a href="javascript:void(0)">{{$cart->Produk->nama}}</a></h5>
                                                        <p class="price">
                                                            <span class="discount text-muted">Rp. 80.000</span>
                                                            <span>Rp. {{$cart->Produk->harga_jual * $cart->quantity}}</span>
                                                        </p>
                                                        <p class="text-muted">Qty: {{$cart->quantity}}</p>
                                                    </div>
                                                </div>

                                            @endforeach

                                        @endguest
                                        </div>
                                    </li>
                                    <li>
                                        <div class="drop-title d-flex justify-content-between">
                                            <span>Total:</span>
                                            <span class="text-primary"><strong>Rp. {{$total}}</strong></span>
                                        </div>
                                    </li>
                                    
                                    <li class="d-flex justify-content-between pl-3 pr-3 pt-3">
                                        <a href="{{ route('cart') }}" class="btn btn-default">View Cart</a>
                                        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
    <div id="page-content" class="page-content">
        @yield('content')
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>About</h5>
                    <p>{{ config('setting.Deskripsi') }}</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul>
                        <li>
                            <a href="{{ route('about') }}">About</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}">FAQ</a>
                        </li>
                        <li>
                            <a href="{{ route('cek.pesanan') }}">Cek Pesanan</a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}">Terms</a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                     <h5>Contact</h5>
                     <ul>
                         <li>
                            <a href="tel:{{ config('setting.Telp') }}"><i class="fa fa-phone"></i> {{ config('setting.Telp') }}</a>
                        </li>
                        <li>
                            <a href="mailto:{{ config('setting.Email') }}"><i class="fa fa-envelope"></i> {{ config('setting.Email') }}</a>
                         </li>
                     </ul>

                     <h5>Follow Us</h5>
                     <ul class="social">
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-facebook-f"></i></a>
                         </li>
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-instagram"></i></a>
                         </li>
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-youtube"></i></a>
                         </li>
                     </ul>
                </div>
                <div class="col-md-3">
                     <h5>Get Our App</h5>
                     <ul class="mb-0">
                         <li class="download-app">
                             <a href="#"><img src="{{ asset('frontend/img/playstore.png') }}"></a>
                         </li>
                         <li style="height: 200px">
                             <div class="mockup">
                                 <img src="{{ asset('frontend/img/mockup.png') }}">
                             </div>
                         </li>
                     </ul>
                </div>
            </div>
        </div>
        <p class="copyright">&copy; 2019 {{ config('setting.NamaToko') }} | All rights reserved.</p>
    </footer>

    <script type="text/javascript" src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery-migrate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/bootstrap/libraries/popper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/bootstrap/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/o2system-ui/o2system-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/owl-carousel/owl-carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/cloudzoom/cloudzoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/thumbelina/thumbelina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/packages/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/theme.js') }}"></script>
    @stack('js')
</body>
</html>
