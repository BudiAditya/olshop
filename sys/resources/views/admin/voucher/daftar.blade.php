@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Voucher
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Voucher</li>
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
                <h4 class="card-title">Daftar Voucher</h4>
                <p class="card-description">
                  Semua daftar voucher produk disini
                </p>
                <a class="btn btn-sm btn-gradient-primary mb-4" href="{{ route('admin.voucher.tambah') }}">Tambah voucher</a></li>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Kode Voucher</th>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Tipe</th>
                      <th>Nilai</th>
                      <th>Stok</th>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Selesai</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($vouchers as $voucher)
                    <tr>
                      <td>{{$voucher->kode_voucher}}</td>
                      <td>{{$voucher->nama}}</td>
                      <td>{{$voucher->deskripsi}}</td>
                      <td>{{$voucher->type}}</td>
                      <td>{{$voucher->value}}</td>
                      <td>{{$voucher->limit_voucher}}</td>
                      <td>{{$voucher->tanggal_mulai}}</td>
                      <td>{{$voucher->tanggal_selesai}}</td>
                      <td>{{$voucher->status}}</td>
                      <td class="d-flex">
                        <a href="voucher/edit/{{$voucher->voucher_id}}" class="btn btn-sm btn-warning">Edit</a> &nbsp;
                        <a href="voucher/hapus/{{$voucher->voucher_id}}" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin menghapus produk ini?')">Hapus</a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                </div>

                <div class="mt-4">
                  {{ $vouchers->links() }}                
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection