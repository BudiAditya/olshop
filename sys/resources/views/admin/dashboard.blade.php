@extends('admin.part.template')

@section('content')
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="{{asset('admin/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Transaksi Hari ini
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5">{{ $transaksi_today }}</h2>
                  <h6 class="card-text">Berdasarkan Harian</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="{{asset('admin/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                  
                  <h4 class="font-weight-normal mb-3">Omset Hari Ini
                    <i class="mdi mdi-swap-horizontal mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5">{{ $omset }}</h2>
                  <h6 class="card-text">Berdasarkan Harian</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="{{asset('admin/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                                    
                  <h4 class="font-weight-normal mb-3">Produk Terjual
                    <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5">{{ $produkterjual }}</h2>
                  <h6 class="card-text">Berdasarkan Harian</h6>
                </div>
              </div>
            </div>
          </div>
          @if(count($topproduk) > 0)
          <div class="row">
            <div class="col-md-4 col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Top Produk Penjualan Hari Ini</h4>
                  @foreach($topproduk as $data)
                  <div class="flex">
                    {{ $data->Produk->nama }} <div class="float-right"> {{ $data->quantity }} </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
        <!-- content-wrapper ends -->
  @endsection

@push('js')
<!-- <script src="{{ asset('admin/js/dashboard.js') }}"></script> -->
  @endpush