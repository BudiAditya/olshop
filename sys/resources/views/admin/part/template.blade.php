<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="_token" content="{!! csrf_token() !!}" />
  <title>{{ config('setting.NamaToko') }} | Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.ico') }}"/>
  @stack('css')
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('index') }}"><img src="{{ asset('frontend/img/logo/logo.png') }}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('index') }}"><img src="{{ asset('frontend/img/logo/icon.png') }}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>                
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="{{ asset('frontend/img/profil.jpg') }}" alt="image">
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <!-- <a class="dropdown-item" href="#">
                <i class="mdi mdi-cached mr-2 text-success"></i>
                Activity Log
              </a>
              <div class="dropdown-divider"></div> -->
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
              >
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Signout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="{{ asset('frontend/img/profil.jpg') }}" alt="profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                <span class="text-secondary text-small">Administrator</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-transaksi" aria-expanded="false" aria-controls="menu-transaksi">
              <span class="menu-title">Transaksi</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-swap-horizontal menu-icon"></i>
            </a>
            <div class="collapse" id="menu-transaksi">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('pembayaran.transaksi') }}">Menunggu Pembayaran</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('resi.transaksi') }}">Proses Pengiriman</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('daftar.transaksi') }}">Daftar Transaksi</a></li>
                <li class="nav-item"> <a class="nav-link" href="#"><del>Komplain Pesanan</del></a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-produk" aria-expanded="false" aria-controls="menu-produk">
              <span class="menu-title">Produk</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-store menu-icon"></i>
            </a>
            <div class="collapse" id="menu-produk">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.product') }}">Daftar Produk</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.kategori') }}">Kategori Produk</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.satuan') }}">Satuan Produk</a></li>
                <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('admin.kategori') }}">Diskon Produk</a></li> -->
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.voucher') }}">
              <span class="menu-title">Voucher</span>
              <i class="mdi mdi-ticket menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.metodepembayaran') }}">
              <span class="menu-title">Metode Pembayaran</span>
              <i class="mdi mdi-cash menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-laporan" aria-expanded="false" aria-controls="menu-laporan">
              <span class="menu-title">Laporan</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-clipboard-text menu-icon"></i>
            </a>
            <div class="collapse" id="menu-laporan">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.laporan') }}">Laporan Transaksi</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.laporan.produk') }}">Laporan Produk</a></li>
                <!-- <li class="nav-item"> <a class="nav-link" href="#"><del>Laporan Lainnya</del></a></li> Laporan  Voucher Diskon Dsb -->
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-pengaturan" aria-expanded="false" aria-controls="menu-laporan">
              <span class="menu-title">Pengaturan</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-settings menu-icon"></i>
            </a>
            <div class="collapse" id="menu-pengaturan">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('register.admin.view') }}">Daftar Admin</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('admin.pengaturan') }}">Pengaturan Toko</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      
      <!-- partial -->
      <div class="main-panel">

              @yield('content')
              
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Develop by <a href="http://ashern11.github.io" target="_blank">Ashmedia</a></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->

      </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin/js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('admin/js/file-upload.js') }}"></script>
  <!-- End custom js for this page-->
  @stack('js')
</body>

</html>
