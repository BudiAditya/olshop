@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              voucher
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.voucher') }}">voucher</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit voucher</h4>
                  <p class="card-description">
                    Silahkan edit form voucher dibawah
                  </p>
                  <form class="forms-sample" action="{{ route('admin.voucher.proses.edit') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <input type="hidden" class="form-control" name="id" id="id" value="{{$voucher->voucher_id}}">
                    <div class="form-group">
                      <label for="kode">Kode voucher</label>
                      <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode Voucher" value="{{$voucher->kode_voucher}}" required>
                    </div>
                    <div class="form-group">
                      <label for="nama">Nama voucher</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Voucher" value="{{$voucher->nama}}" required>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{$voucher->deskripsi}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="type">Tipe Voucher</label>
                      <select name="type" id="type" class="form-control">
                        <option value="fixed">Tetap</option>
                        <option value="percent">Persen</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nilai">Nilai Voucher</label>
                      <input type="text" class="form-control" name="nilai" id="nilai" placeholder="nilai" value="{{$voucher->value}}" required>
                    </div>
                    <div class="form-group">
                      <label for="stok">Stok Voucher</label>
                      <input type="text" class="form-control" name="stok" id="stok" placeholder="stok" value="{{$voucher->limit_voucher}}" required>
                    </div>
                    <div class="form-group">
                      <label for="tanggal_mulai">Tanggal Mulai</label>
                      <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" placeholder="tanggal_mulai" value="{{$voucher->tanggal_mulai}}" required>
                    </div>
                    <div class="form-group">
                      <label for="tanggal_selesai">Tanggal Selesai</label>
                      <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" placeholder="tanggal_selesai" value="{{$voucher->tanggal_selesai}}" required>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    <a href="{{ route('admin.voucher') }}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection