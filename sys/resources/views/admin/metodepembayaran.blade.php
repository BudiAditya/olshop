@extends('admin.part.template')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/daterangepicker.css') }}" />
<style>
.mutasi tbody tr{
  background: none;
  border-bottom: 1px solid #444;
}
.mutasi tbody tr td{
  padding: 8px 0;
}
</style>
@endpush
@section('content')
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Metode Pembayaran
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
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
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder">
                <div class="card-body">
                  <form action="{{ route('admin.changebca') }}" method="post">
                    @csrf
                    <h4 class="font-weight-normal mb-3">Bank BCA
                    </h4>
                    <div class="form-group">
                      <label for="norek">Nama Rekening</label>
                      <input type="text" name="NamaBCA" id="NorekBCA" class="form-control" value="{{config('setting.NamaBCA')}}">
                    </div>
                    <div class="form-group">
                      <label for="norek">No Rekening</label>
                      <input type="text" name="NorekBCA" id="NorekBCA" class="form-control" value="{{config('setting.NorekBCA')}}">
                    </div>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder">
                <div class="card-body">
                  <form action="{{ route('admin.changebca') }}" method="post">
                    @csrf
                    <h4 class="font-weight-normal mb-3">Klik BCA (Konfirmasi Otomatis)
                    </h4>
                    <div class="form-group">
                      <label for="norek">Username KlikBca</label>
                      <input type="text" name="UserBCA" id="UserBCA" class="form-control" value="{{config('setting.UserBCA')}}">
                    </div>
                    <div class="form-group">
                      <label for="norek">Password KlikBCA</label>
                      <input type="password" name="PassBCA" id="PassBCA" class="form-control" value="{{config('setting.PassBCA')}}">
                    </div>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card bg-gradient-warning card-img-holder">
                <div class="card-body">
                  <h4>Fitur Mutasi Klik BCA</h4>
                  <div class="row">
                    <div class="col-2">
                      <button class="btn btn-primary btn-sm" id="cekSaldo">Cek Saldo</button>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <div class="input-group">
                          <input type="text" class="form-control" name="daterange">
                          <div class="input-group-append">
                            <button id="cekMutasi" class="btn btn-sm btn-gradient-primary" type="button">Cek Mutasi Saldo</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="saldo"></div>
                      <div class="mutasi"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('admin/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/js/misc.js') }}"></script>
<script>
  var tanggal_mulai, tanggal_selesai;
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    tanggal_mulai = start.format('YYYY-MM-DD');
    tanggal_selesai = end.format('YYYY-MM-DD');
    console.log(tanggal_mulai +" <> "+ tanggal_selesai)
  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });

  $('#cekMutasi').click(function(){
    $('.mutasi').empty();
    serializedData = { dari_tanggal : tanggal_mulai, sampai_tanggal: tanggal_selesai};
    $.post('{{ route("admin.cekmutasi") }}', serializedData, function (data) {
      $('.mutasi').append(data);
    });
  })

  $('#cekSaldo').click(function(){
    $('.saldo').empty();
    $.get('{{ route("admin.ceksaldo") }}', function (data) {
      html = `<h5>Total Saldo : `+data[0]['saldo']+`</h5>`;
      $('.saldo').append(html);
    });
  })


</script>
@endpush