@extends('frontend.part.template')

@push('css')
<style>
    tr.detail-produk td{
        padding: .25em;
    }
    tr.detail-produk td:first-child{
        width : 12%;
    }
    tr.detail-produk td:nth-child(2){
        width : 50%;
    }
    tr.detail-produk td:nth-child(3){
        width : 8%;
        text-align: center;
    }
    tr.detail-produk td:nth-child(4){
        width : 30%;
        text-align: right;
    }
    .table td, .table th{
        border: 0;
    }
    td.bg-danger{
        color: #ca5e65;
        background: #ffe9e9 !important
    }
    .kurir-title{
        text-transform: uppercase;
    }
</style>
@endpush

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{asset('frontend/img/bg-header.jpg')}}');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Transactions
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="nav flex-column">
                            <a class="nav-link active text-primary" href="{{ route('transaksi') }}">Transaksi</a>
                            <a class="nav-link" href="{{ route('pengaturan') }}">Pengaturan</a>
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Layanan Bantuan</a>
                        </nav>
                    </div>

                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a href="{{ route('transaksi', ['orderby' => 'semua']) }}" class="nav-link @if(Request::is('transaksi/semua')) active @endif">Semua</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transaksi', ['orderby' => 'pending']) }}" class="nav-link @if(Request::is('transaksi/pending')) active @endif">Menunggu Pembayaran</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transaksi', ['orderby' => 'diproses']) }}" class="nav-link @if(Request::is('transaksi/diproses')) active @endif">Diproses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transaksi', ['orderby' => 'dikirim']) }}" class="nav-link @if(Request::is('transaksi/dikirim')) active @endif">Dikirim</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transaksi', ['orderby' => 'selesai']) }}" class="nav-link @if(Request::is('transaksi/selesai')) active @endif">Telah Sampai</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <br><br><br>
                                                    
                            <div class="col-12">

                                @foreach ($transaksi as $data)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6>FAKTUR #INV{{$data->transaksi_id}}</h6>
                                                <hr>
                                                <small>2019-07-08 09:18:24</small> <br>
                                                <span class="nama-lengkap font-weight-bold">{{$data->Alamat->nama_depan.' '.$data->Alamat->nama_belakang}}</span> <br>
                                                <span class="alamat">{{$data->Alamat->alamat}}</span> <br>
                                                <span class="kecamatan">{{$data->Alamat->kecamatan}}</span> <br>
                                                <span class="kota">Kota {{$data->Alamat->kota}}</span> <br>
                                                <span class="provinsi">{{$data->Alamat->provinsi}},</span>
                                                <span class="kode-pos"> {{$data->Alamat->kode_pos}}</span>
                                                <br><br>
                                                <div class="card">
                                                    <div class="card-body pt-3">
                                                    @if($data->kurir)
                                                            <img src="{{ asset('frontend/img/kurir').'/'.$data->kurir.'.png' }}" class="img-responsive float-left" width="120" alt="">
                                                            <strong class="kurir-title">{{$data->kurir}}</strong> <br>
                                                            {{$data->kurir_service}}
                                                    @else
                                                        <span>Contact administrator!</span>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6>Produk</h6>
                                                <hr>
                                                <table class="table table-striped m-0">
                                                    <?php $total = 0; ?>
                                                    @foreach(\App\Model\TransaksiDetail::where('transaksi_id', $data->transaksi_id)->get() as $transaksi_detail)
                                                    <?php $total += $transaksi_detail->quantity * $transaksi_detail->harga_jual ?>
                                                    <tr class="detail-produk">
                                                        <td>{{ $transaksi_detail->quantity }}</td>
                                                        <td>{{ $transaksi_detail->Produk->nama }}</td>
                                                        <td>@</td>
                                                        <td>Rp {{ $transaksi_detail->quantity * $transaksi_detail->harga_jual }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                                <table class="table table-borderless">
                                                    <tr class="detail-produk border-top">
                                                        <td></td>
                                                        <td class="text-right pr-2">Sub Total</td>
                                                        <td>:</td>
                                                        <td>Rp {{ $total }}</td>
                                                    </tr>
                                                    <tr class="detail-produk">
                                                        <td></td>
                                                        <td class="text-right pr-2">Ongkos Kirim</td>
                                                        <td>:</td>
                                                        <td>Rp {{ $data->total_transaksi - $total }}</td>
                                                    </tr>
                                                    <tr class="detail-produk">
                                                        <td></td>
                                                        <td class="text-right pr-2">Voucher</td>
                                                        <td>:</td>
                                                        <td>Rp {{ !empty($data->voucher) ? $data->voucher : 0 }} </td>
                                                    </tr>
                                                    <tr class="detail-produk">
                                                        <td></td>
                                                        <td class="text-right pr-2">Kode Unik</td>
                                                        <td>:</td>
                                                        <td>{{ $data->kode_unik }}</td>
                                                    </tr>
                                                    <tr class="detail-produk">
                                                        <td class="bg-danger"></td>
                                                        <td class="bg-danger text-right pr-2">Total</td>
                                                        <td class="bg-danger">:</td>
                                                        <td class="bg-danger font-weight-bold">Rp {{ $data->total_transaksi + $data->kode_unik - $data->voucher }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col">
                                                <h6>Detail</h6>
                                                <hr>
                                                <div class="text-center">
                                                    @if($data->status_pembayaran == 'Menunggu Pembayaran')
                                                        <div class="text-left">
                                                            <strong>Status :</strong>
                                                            <span class="text-info">{{ $data->status_pembayaran }}</span> <br>
                                                        </div>
                                                        <br>

                                                        <div class="card">
                                                            <div class="card-body row">
                                                                <div class="col border-right">
                                                                    Metode Pembayaran <br>
                                                                </div>
                                                                <div class="col">
                                                                    <img src="{{ asset('frontend/img/bca.png') }}" class="img-responsive" width="100" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <br>
                                                        <button class="btn btn-info btn-sm">Cara Bayar <i class="fa fa-question-circle"></i></button>
                                                        <button class="btn btn-success btn-sm">Konfirmasi Pembayaran <i class="fa fa-check-circle"></i></button>
                                                    @elseif($data->status_pengiriman == 'Sedang Diproses')
                                                        <strong>Status :</strong>
                                                        <h6 class="border border-info text-info px-4 py-2">Sedang Diproses</h6>
                                                        *Pesanan anda sedang dikemas dan akan segera dikirim
                                                    @elseif($data->status_pengiriman == 'Sedang Dikirim')
                                                        <strong>Status :</strong>
                                                        Status :
                                                        <h6 class="border border-warning text-warning px-4 py-2">Sedang Dikirim</h6>
                                                        <span class="d-block">No Resi : {{ $data->no_resi }}</span>
                                                        <button class="btn btn-success btn-sm btn-cek" data-resi="{{ $data->no_resi }}"><i class="fa fa-search"></i> Lacak Pengiriman</button>
                                                    @elseif($data->status_pengiriman == 'Telah Sampai')
                                                        <strong>Status :</strong>
                                                        <h6 class="border border-success text-success px-4 py-2">Selesai</h6>
                                                        *Status transaksi sudah selesai, Pesanan telah diterima
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                
                            </div>

                            <div class="col-12">
                                <div class="text-center">
                                    <nav aria-label="Page navigation">
                                        {{ $transaksi->links() }}
                                    </nav>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title"></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });

  $(".btn-cek").click(function(){   
    let noresi = $(this).data('resi');
    $.get("{{ url('admin-panel/transaksi/resi/cek') }}"+'/'+ noresi, function(data){
      console.log(data);
      var manifest ="";
      // Manifest
      for(var x=0; x<data["manifest"].length; x++){
        manifest += `<tr>
                    <td>`+data["manifest"][x]["manifest_date"]+`</td>
                    <td>`+data["manifest"][x]["manifest_description"]+`</td>
                  </tr>`;
      }

      html =`<table class="table">
                <tbody>
                  <tr style="text-align: left">
                    <th width="30%">Tanggal</th>
                    <th width="70%">Keterangan</th>
                  </tr>
                  
                  `+manifest+`
                </tbody>
              </table>`;

      $('#myModal .modal-body').empty();
      $('#myModal .modal-body').append(html);
      $('h6.modal-title').text('Lacak Pengiriman');
      $('#myModal').modal();
    })
  });
</script>
@endpush