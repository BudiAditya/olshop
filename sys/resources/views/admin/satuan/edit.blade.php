@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Satuan
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.satuan') }}">Satuan</a></li>
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
                  <h4 class="card-title">Edit Satuan</h4>
                  <p class="card-description">
                    Silahkan edit form satuan dibawah
                  </p>
                  <form class="forms-sample" action="{{ route('admin.satuan.proses.edit') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" class="form-control" name="id" id="id" value="{{$satuan->satuan_id}}">
                    <div class="form-group">
                      <label for="nama">Nama Satuan</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Satuan" value="{{$satuan->satuan_nama}}" required>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{$satuan->satuan_deskripsi}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    <a href="{{ route('admin.satuan') }}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection