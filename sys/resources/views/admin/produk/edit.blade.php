@extends('admin.part.template')

@section('content')     
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Tambah Produk
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Produk</a></li>
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
                  <h4 class="card-title">Tambahkan Produk Disini</h4>
                  <p class="card-description">
                    Silahkan isi detail produk dengan sedetailnya
                  </p>
                  <form class="forms-sample" action="{{ route('admin.product.proses.edit') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" class="form-control" name="id" id="id" value="{{$product->id}}">
                    <div class="form-group">
                      <label for="nama">Nama Produk</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Produk" value="{{$product->nama}}" required>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required>{{$product->deskripsi}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="kategori">Kategori</label>
                      <select class="form-control" name="kategori" id="kategori">
                        <option value="0">-</option>
                        @foreach ($kategori as $value)
                          <option value="{{$value->kategori_id}}"
                          @if ($value->kategori_id == $product->kategori_id)
                            {{"selected"}}
                          @endif
                          >
                            {{$value->kategori_nama}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="satuan">Satuan</label>
                      <select class="form-control" name="satuan" id="satuan">
                        <option value="0">-</option>
                        @foreach ($satuan as $value)
                          <option value="{{$value->satuan_id}}" 
                          @if ($value->satuan_id == $product->satuan_id)
                            {{"selected"}}
                          @endif
                          >
                            {{$value->satuan_nama}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="berat">Berat</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="berat" id="berat" placeholder="berat" value="{{$product->berat}}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Gram</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="stok">Stok</label>
                          <input type="text" class="form-control"name="stok" id="stok" placeholder="stok" value="{{$product->stok}}" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="exampleInputCity1">Harga Beli</label>
                          <input type="text" class="form-control" name="harga_beli" id="harga_beli" value="{{$product->harga_beli}}" placeholder="Harga Beli" required>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="harga_jual">Harga Jual</label>
                          <input type="text" class="form-control" name="harga_jual" id="harga_jual" value="{{$product->harga_jual}}" placeholder="Harga Jual" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Gambar upload</label>
                      <input type="file" name="gambar[]" class="file-upload-default" multiple="multiple">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    <a href="{{ route('admin.product') }}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection