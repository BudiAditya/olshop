@extends('admin.part.template')
@push('css')
<style>
input[type="file"]{
    display: none;
}
</style>
@endpush

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Konfigurasi
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Konfigurasi</li>
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
                <h4 class="card-title">Konfigurasi</h4>
                <p class="card-description">
                  Semua daftar konfigruasi ada disini
                </p>

                <h5>Ubah Logo dan Favicon</h5>    
                <div class="row">
                  <div class="col-5">
                    <div class="card bg-light">
                      <div class="card-body">
                          <img src="{{ asset('img/favicon.ico') }}" class="img-responsive float-left mr-4" width="50" height="50" alt="">
                          <form action="{{ route('admin.pengaturan.updateFavicon') }}" method="POST" enctype="multipart/form-data" id="formGambar">
                          @csrf
                          <label class="btn btn-primary btn-sm ubahGambar">
                              <input type="file"  name="gambar"/>
                              Upload Favicon
                          </label>
                          </form>
                          <br>
                          <small class="d-block">Besar file: maksimum 500 Kilobytes</small>
                          <small class="d-block">Ekstensi file yang diperbolehkan: .ICO</small>
                          <small class="d-block">Ratio Gambar diharuskan 1:1</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="card bg-light">
                      <div class="card-body">
                          <img src="{{ asset('img/logo.png') }}" class="img-responsive float-left mr-4" width="200" height="100" alt="">
                          <form action="{{ route('admin.pengaturan.updateLogo') }}" method="POST" enctype="multipart/form-data" id="formGambar">
                          @csrf
                          <label class="btn btn-primary btn-sm ubahGambar">
                              <input type="file"  name="gambar"/>
                              Upload Logo
                          </label>
                          </form>
                          <small class="d-block">Besar file: maksimum 2 Megabytes</small>
                          <small class="d-block">Ekstensi file yang diperbolehkan: .PNG</small>
                          <small class="d-block">Ratio Gambar diharuskan 4:1</small>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                
                <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                @csrf
                @foreach ($configs as $config)
                  <div class="form-group">
                    <label for="">{{$config->nama}}</label>
                    @if($config->nama == "DikirimDari")
                      <span class="text-muted">( ID Kota dari Rajaongkir )</span>
                    @endif
                    <input type="text" class="form-control" name="{{$config->nama}}" value="{{$config->value}}" required> 
                  </div>
                @endforeach
                  <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                  <button type="reset" class="btn btn-gradient-secondary mr-2">Reset</button>
                </form>
              </div>
            </div>
          </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection

@push('js')
<script>
    $('.ubahGambar').change(function(){
        $(this).parent().parent().find('form')[0].submit();
    });
</script>
@endpush