@extends('frontend.part.template')
@push('css')
<style>
input[type="file"]{
    display: none;
}
</style>
@endpush

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{asset('frontend/img/bg-header.jpg')}}');">
                <div class="container">
                    <h1 class="pt-5">
                        Settings
                    </h1>
                    <p class="lead">
                        Update Your Account Info
                    </p>
                </div>
            </div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="{{ route('transaksi') }}">Transaksi</a>
                            <a class="nav-link active text-primary" href="{{ route('pengaturan') }}">Pengaturan</a>
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Customer Service</a>
                        </nav>
                    </div>

                    <div class="col-10">
                        <div class="row ">
                            <div class="col-12 col-sm-6 border-right">
                                    <h5>Profil</h5>    
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <img src="{{ asset('img/'.Auth::user()->gambar) }}" class="img-responsive float-left mr-4" width="150" height="150" alt="">
                                            <form action="{{ route('pengaturan.updateProfilGambar') }}" method="POST" enctype="multipart/form-data" id="formGambar">
                                            @csrf
                                            <label class="btn btn-primary btn-sm" id="ubahGambar">
                                                <input type="file"  name="gambar"/>
                                                Upload Gambar
                                            </label> <br>
                                            </form>
                                            <small class="d-block">Besar file: maksimum 2 Megabytes</small>
                                            <small class="d-block">Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</small>
                                            <small class="d-block">Ratio Gambar diharuskan 1:1</small>
                                        </div>
                                    </div>
                                    <br>
                                    @if (session('profil'))
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('profil') }}
                                    </div>
                                    @endif
                                <form action="{{ route('pengaturan.updateProfil') }}" method="post">
                                    <div class="form-group">
                                        @csrf
                                        <label for="name">Nama Lengkap</label>
                                        <input class="form-control" name="name" placeholder="Nama Lengkap" id="name" type="text" value="{{ Auth::user()->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Bio</label>
                                        <textarea class="form-control" name="bio" placeholder="Bio">{{ Auth::user()->bio }}</textarea>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="name">Email</label>
                                            <input class="form-control" name="email" placeholder="Email Address" type="email"  value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                        <div class="col">
                                            <label for="name">No HP</label>
                                            <input class="form-control" name="no_hp" placeholder="Phone Number" type="tel"  value="{{ Auth::user()->no_hp }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">UPDATE PROFIL</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>


                                <br><br>
                                <form action="{{ route('pengaturan.updatePassword') }}" method="post">
                                    <h5>Password</h5>
                                    @if (session('password'))
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('password') }}
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        @csrf
                                        <input class="form-control" name="password_lama" placeholder="Password Lama" type="password">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="password_baru" placeholder="Password Baru" type="password">
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">UPDATE PASSWORD</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h5 class="mb-3">DAFTAR ALAMAT</h5>

                                @if (session('alamat'))
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('alamat') }}
                                    </div>
                                @endif

                                @foreach ($alamats as $alamat)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <strong class="nama-lengkap">{{ $alamat->nama_depan.' '.$alamat->nama_belakang }}</strong> <br>
                                        <span class="alamat">{{ $alamat->nama_perusahaan.' '.$alamat->alamat }}</span> <br>
                                        <span class="kecamatan">{{ $alamat->kecamatan }}</span>,
                                        <span class="kota">{{ $alamat->kota }}</span> <br>
                                        <span class="provinsi">{{ $alamat->provinsi }}</span>,
                                        <span class="kode-pos"> {{ $alamat->kode_pos }}</span>
                                    </div>
                                </div>
                                @endforeach

                                <div class="text-right mt-2">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Alamat</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Alamat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pengaturan.tambahalamat') }}" method="post" class="bill-detail">
                    <div class="modal-body">
                        <!-- Bill Detail of the Page -->
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        @csrf
                                        <input class="form-control" name="nama_depan" placeholder="Nama Depan" type="text">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="nama_belakang" placeholder="Nama Belakang" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="nama_perusahaan" placeholder="Nama Perusahaan" type="text">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" name="provinsi" placeholder="Provinsi" type="text">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="kota" placeholder="Kota" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" name="kecamatan" placeholder="Kecamatan" type="text">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="kode_pos" placeholder="Postcode / Zip" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="no_hp" placeholder="Nomor HP Penerima" type="tel" required>
                                </div>
                            </fieldset>
                        <!-- Bill Detail of the Page end -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@push('js')
<script>
    $('#ubahGambar').change(function(){
        $('#formGambar')[0].submit();
    });
</script>
@endpush