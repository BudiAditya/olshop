@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Produk
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
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
                <h4 class="card-title">Daftar Produk</h4>
                <p class="card-description">
                  Semua daftar produk
                </p>
                <a class="btn btn-sm btn-gradient-primary mb-4" href="{{ route('admin.product.tambah') }}">Tambah Produk</a></li>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Nama Produk</th>
                        <th>Berat(gram)</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($product as $data)
                      <tr>
                        <td>{{$data->nama}}</td>
                        <td>{{$data->berat}}</td>
                        <td>{{$data->harga_jual}}</td>
                        <td class="d-flex">
                          <a href="produk/edit/{{$data->id}}" class="btn btn-sm btn-warning">Edit</a> &nbsp;
                          <a href="produk/hapus/{{$data->id}}" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>

                <div class="mt-4">
                {{ $product->links() }}                
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection