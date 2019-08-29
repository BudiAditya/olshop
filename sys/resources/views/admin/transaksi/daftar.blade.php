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
                <a class="btn btn-sm btn-gradient-primary mb-4" href="{{ route('cek.bayar.bca') }}">Cek Pembayaran</a>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Invoice</th>
                      <th>Total</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $x=1 ?>
                  @foreach ($transaksi as $data)
                    <tr>
                      <td>{{$x++}}</td>
                      <td>INV{{$data->transaksi_id}}</td>
                      <td>{{$data->total_transaksi}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->status_pembayaran}}</td>
                      <td class="d-flex">
                        <a href="detail/{{$data->transaksi_id}}" class="btn btn-sm btn-info">Detail</a> &nbsp;
                        <a href="konfirmasi/{{$data->transaksi_id}}" class="btn btn-sm btn-warning" onclick="return confirm('anda yakin ingin menkonfirmasi transaksi ini?')">Konfirmasi</a> &nbsp;
                        <a href="hapus/{{$data->transaksi_id}}" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin menghapus produk ini?')">Tolak</a>
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