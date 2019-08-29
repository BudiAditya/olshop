@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Transaksi
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
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
                <h4 class="card-title">Daftar Transaksi</h4>
                <p class="card-description">
                  Semua daftar transaksi produk disini
                </p>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Invoice</th>
                      <th>Total</th>
                      <th>Metode Pembayaran</th>
                      <th>Status Pembayaran</th>
                      <th>Status Transaksi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($transaksi as $data)
                    <tr>
                      <td>{{$data->created_at}}</td>
                      <td>INV{{$data->transaksi_id}}</td>
                      <td>{{$data->total_transaksi}}</td>
                      <td>{{$data->jenis_pembayaran}}</td>
                      <td>{{$data->status_pembayaran}}</td>
                      <td>{{$data->status_transaksi}}</td>
                      <td class="d-flex">
                        <a href="detail/{{$data->transaksi_id}}" class="btn btn-sm btn-info">Detail</a> &nbsp;
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                </div>

                <div class="mt-4">
                  {{ $transaksi->links() }}
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection