@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Laporan Transaksi
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Laporan</li>
              </ol>
            </nav>
          </div>
          <div class="row">

          @if (session('success'))
            <div class="col-12">
              <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ session('success') }}
              </div>
            </div>
          @endif

          @if(count($errors))
            <div class="col-12">
              <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
            
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Laporan Penjualan</h4>
                <p class="card-description">
                  Jangan lupa laporan
                </p>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Invoice</th>
                      <th>Tanggal</th>
                      <th>Voucher</th>
                      <th>Diskon</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($laporan as $data)
                    <tr>
                      <td>INV{{$data->transaksi_id}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->voucher}}</td>
                      <td>{{$data->diskon}}</td>
                      <td>{{$data->total_transaksi}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection