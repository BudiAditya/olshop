@extends('frontend.part.template')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style>
.pilih-pengiriman label{
    width: 100%;
    height: 100%;
}

.pilih-pengiriman [type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.pilih-pengiriman [type=radio] + .pilihan {
  cursor: pointer;
  border-radius: 10px;
  background: #f5f5f5;
  padding: 10px;
  margin: 4px;
  width: 100%;
  height: 100%;
}

/* CHECKED STYLES */
.pilih-pengiriman [type=radio]:checked + .pilihan {
  border: 1px solid #505050;
}

span.select2{
    width: 100%!important;
}
</style>
@endpush
@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{asset('frontend/img/bg-header.jpg')}}');">
                <div class="container">
                    <h1 class="pt-5">
                        Checkout
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="checkout">
            <div class="container">
            <form action="{{ route('checkout.proses') }}" method="POST" class="bill-detail">
            {{ csrf_field() }}

                <div class="row">
                    <div class="col-xs-12 col-sm-7">

                    @guest

                        <h5 class="mb-3">ALAMAT BARU</h5>
                        <!-- Bill Detail of the Page -->
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        <input class="form-control" name="nama_depan" placeholder="Nama Depan" type="text" required>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="nama_belakang" placeholder="Nama Belakang" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="nama_perusahaan" placeholder="Nama Perusahaan" type="text">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="alamat" placeholder="Alamat" required></textarea>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12">
                                        <select class="form-control select-provinsi" name="provinsi">
                                            <option selected disabled>Provinsi</option>
                                        @foreach ($provinsi as $prov)
                                            <option data-id="{{ $prov['province_id'] }}" value="{{ $prov['province'] }}">{{ $prov['province'] }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <select class="form-control select-kota" name="kota">
                                            <option selected disabled>Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <select class="form-control select-kecamatan" name="kecamatan">
                                            <option selected disabled>Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" name="kode_pos" placeholder="Kode POS" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="no_hp" placeholder="No HP" type="tel" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="catatan" placeholder="Catatan"></textarea>
                                </div>
                            </fieldset>
                        <!-- Bill Detail of the Page end -->

                    @else

                        <!-- Alamat apabila user pernah transaksi -->
                        <h5>Pilih Alamat</h5>
                        @if(!is_null($alamats))

                        <div class="mb-4">
                            <select  class="form-control daftar-alamat" name="daftar-alamat">
                                <option selected disabled>Pilih alamat disini</option>
                            @foreach($alamats as $alamat)
                                <option value="{{$alamat->alamat_id}}" data-rajaongkir="{{$alamat->kode_rajaongkir}}">{{$alamat->nama_depan.' '.$alamat->nama_belakang.' ('.$alamat->alamat.', '.$alamat->provinsi.', '.$alamat->kode_pos.')'}}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif

                        @if (session('alamat'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('alamat') }}
                            </div>
                        @endif
                        <span class="btn btn-primary" data-toggle="modal" data-target="#modalAlamat">Tambah Alamat</span>
                        
                    @endguest

                    <div class="mt-5 pilih-pengiriman">
                        <!-- Rendered by JS -->
                    </div>


                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="row">
                            <div class="col-12 order-2">
                                <button type="submit" name="submit" class="btn btn-primary float-right">PROCEED TO CHECKOUT <i class="fa fa-check"></i></button>
                                </form>
                            </div>

                            <div class="col-12 order-1">
                                <div class="holder">
                                    <h5 class="mb-3">YOUR ORDER</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Products</th>
                                                    <th class="text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                            $total = 0; 
                                            $berat = 0;
                                            ?>

                                            @guest

                                                @if(session('cart'))
                                                @foreach(session('cart') as $id => $product)
                                                <?php
                                                $total += $product['harga'] * $product['quantity'];
                                                $berat += $product['berat'] * $product['quantity'];
                                                ?>
                                                    <tr>
                                                        <td>
                                                        {{$product['nama']}} x{{$product['quantity']}}
                                                        </td>
                                                        <td class="text-right">
                                                            Rp {{$product['harga'] * $product['quantity']}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif

                                            @else

                                                @foreach($carts as $cart)
                                                <?php
                                                $total += $cart->Produk->harga_jual * $cart->quantity;
                                                $berat += $cart->Produk->berat * $cart->quantity;
                                                ?>
                                                    <tr>
                                                        <td>
                                                        {{$cart->Produk->nama}} x{{$cart->quantity}}
                                                        </td>
                                                        <td class="text-right">
                                                            Rp {{$cart->Produk->harga_jual * $cart->quantity}}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @endguest
                                            </tbody>
                                            <tfooter>
                                                <tr>
                                                    <td>
                                                        <strong>Cart Subtotal</strong>
                                                    </td>
                                                    <td class="text-right">
                                                        Rp {{$total}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Ongkir</strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="hidden" name="kode_rajaongkir" value="">
                                                        <input type="hidden" name="kurir" value="">
                                                        <input type="hidden" name="service" value="">
                                                        <input type="hidden" name="ongkir" value="">
                                                        Rp <span class="harga-ongkir">0</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Voucher</strong>
                                                    </td>
                                                    <td class="text-right">
                                                         
                                                        @if (session()->has('voucher'))
                                                            @if(session()->get('voucher')['type'] == 'fixed')
                                                                Rp. {{ number_format(session()->get('voucher')['value'], 0, ",", ".") }}
                                                            @elseif(session()->get('voucher')['type'] == 'percent')
                                                                Diskon {{ session()->get('voucher')['value'] }} %
                                                            @endif
                                                        @else
                                                            Rp 0
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>ORDER TOTAL</strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <strong>Rp <span class="harga-total">
                                                        @if (session()->has('voucher'))
                                                            {{ number_format($total - session()->get('voucher')['value'], 0, ",", ".") }}
                                                        @else
                                                            {{ number_format($total, 0, ",", ".") }}
                                                        @endif
                                                        </span></strong>
                                                    </td>
                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>

                                    <h5 class="mb-3">Voucher</h5>
                                    @if (!session()->has('voucher'))
                                    <form action="{{ route('check.voucher') }}" method="post">
                                        @csrf
                                        <div class="input-group col-12 col-sm-8 mb-4 voucher">
                                            <input class="form-control" placeholder="Coupon Code" name="kode_voucher" id="kode_voucher" type="text">
                                            <div class="input-group-append">
                                                <button class="btn btn-default" type="submit">Apply</button>
                                            </div>
                                            <div class="pesan mt-2">
                                            @if (session('notif_voucher'))
                                                <div class="alert alert-success">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{ session('notif_voucher') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <div class="input-group col-12 col-sm-8 mb-4 voucher">
                                        <input class="form-control" placeholder="Coupon Code" name="kode_voucher" id="kode_voucher" type="text" value="{{ session()->get('voucher')['kode_voucher'] }}" disabled>
                                        <div class="input-group-append">
                                            <form action="{{ route('del.voucher') }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-default" alt="Hapus Voucher"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                        <div class="pesan mt-2">
                                        @if (session('notif_voucher'))
                                            <div class="alert alert-success">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ session('notif_voucher') }}
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    @endif

                                    <h5 class="mb-3">PAYMENT METHODS</h5>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pembayaran" id="exampleRadios1" value="BCA" checked>
                                            BCA
                                        </label>
                                    </div>
                                    <!-- <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pembayaran" id="exampleRadios2" value="BNI">
                                            BNI
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pembayaran" id="exampleRadios2" value="MANDIRI">
                                            MANDIRI
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pembayaran" id="exampleRadios2" value="BRI">
                                            BRI
                                        </label>
                                    </div> -->
                                </div>
                                <p class="text-right mt-3">
                                    <input checked="" type="checkbox"> I’ve read &amp; accept the <a href="#">terms &amp; conditions</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="modalAlamat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pengaturan.tambahalamat') }}" method="post">
                <div class="modal-body">
                    <!-- Bill Detail of the Page -->
                        <fieldset>
                            <div class="form-group row">
                                <div class="col">
                                    @csrf
                                    <input type="hidden" name="rajaongkir" id="rajaongkir">
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
                                    <select class="form-control select-provinsi" name="provinsi">
                                        <option selected disabled>Provinsi</option>
                                    @foreach ($provinsi as $prov)
                                        <option data-id="{{ $prov['province_id'] }}" value="{{ $prov['province'] }}">{{ $prov['province'] }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control select-kota" name="kota">
                                        <option selected disabled>Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <select class="form-control select-kecamatan" name="kecamatan">
                                        <option selected disabled>Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input class="form-control" name="kode_pos" placeholder="Kode POS" type="text" required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select-provinsi').select2().on("change", function(){
        $(".select-kota").empty();
        var id = $(".select-provinsi option:selected").data('id');
        $.get('{{ url("/rajaongkir/kota/") }}'+ '/' + id, function (data) {
            console.log(data);
            $(".select-kota").append("<option selected disabled>Kota</option>");
            for(var x=0; x<data.length; x++){
                $(".select-kota").append("<option data-id='"+data[x]['city_id']+"' value='"+data[x]['city_name']+"'>"+data[x]['city_name']+"</option>");
            }
        });
    });

    $('.select-kota').select2().on("change", function(){
        $(".select-kecamatan").empty();
        var id = $(".select-kota option:selected").data('id');
        $.get('{{ url("/rajaongkir/kecamatan/") }}'+ '/' + id, function (data) {
            console.log(data);
            $(".select-kecamatan").append("<option selected disabled>Kecamatan</option>");
            for(var x=0; x<data.length; x++){
                $(".select-kecamatan").append("<option data-id='"+data[x]['subdistrict_id']+"' value='"+data[x]['subdistrict_name']+"'>"+data[x]['subdistrict_name']+"</option>");
            }
        });
    });

    @guest

    $('.select-kecamatan').select2().on("change", function(){
        var asal = {{config('setting.DikirimDari')}},
        tujuan =  $(".select-kecamatan option:selected").data('id'),
        berat =  "{{$berat}}";
        $("input[name='kode_rajaongkir']").val(tujuan);
        $(".pilih-pengiriman").empty();
        $.get('{{ url("/rajaongkir/cekongkir/") }}'+ '/' + asal + '/' + tujuan + '/' + berat, function (data) {
            console.log(data);
            var html=`<h6> Pilih Pengiriman</h6>
                      <div class="form-group row row-eq-height">`;
            for(var x=0; x<data.length; x++){
               html += `<div class="col-4 mb-2">
                            <label>
                                <input type="radio" name="pengiriman" onclick="ubahOngkir('`+data[x]['code']+`','`+data[x]['service']+`',`+data[x]['ongkir']+`)">
                                <div class="pilihan">
                                    <img src="frontend/img/kurir/`+data[x]['code']+`.png" class="img-fluid mb-2" width="120" alt=""> <br/>
                                    Service: <strong>`+data[x]['service']+`</strong> <br/>
                                    Harga: <strong>`+data[x]['ongkir']+`</strong> <br/>
                                </div>
                            </label>
                        </div>`;
            }
            html += `</div>`;
            $(".pilih-pengiriman").append(html);
        });
    });

    @else

    $('.daftar-alamat').select2().on("change", function(){
        var asal = {{config('setting.DikirimDari')}},
        tujuan = $(".daftar-alamat option:selected").data('rajaongkir'),
        berat =  "{{$berat}}";
        $("input[name='kode_rajaongkir']").val(tujuan);
        $(".pilih-pengiriman").empty();
        $.get('{{ url("/rajaongkir/cekongkir/") }}'+ '/' + asal + '/' + tujuan + '/' + berat, function (data) {
            console.log(data);
            var html=`<h6> Pilih Pengiriman</h6>
                      <div class="form-group row row-eq-height">`;
            for(var x=0; x<data.length; x++){
               html += `<div class="col-4 mb-2">
                            <label>
                                <input type="radio" name="pengiriman" onclick="ubahOngkir('`+data[x]['code']+`','`+data[x]['service']+`',`+data[x]['ongkir']+`)">
                                <div class="pilihan">
                                    <img src="frontend/img/kurir/`+data[x]['code']+`.png" class="img-fluid mb-2" width="120" alt=""> <br/>
                                    Service: <strong>`+data[x]['service']+`</strong> <br/>
                                    Harga: <strong>`+data[x]['ongkir']+`</strong> <br/>
                                </div>
                            </label>
                        </div>`;
            }
            html += `</div>`;
            $(".pilih-pengiriman").append(html);
        });
    });

    $('.select-kecamatan').select2().on("change", function(){
        $("#rajaongkir").val($(".select-kecamatan option:selected").data('id'));
    });

    @endguest

    ubahOngkir = function(kurir, service, harga){
        $("input[name='kurir']").val(kurir);
        $("input[name='service']").val(service);
        $("input[name='ongkir']").val(harga);
        $(".harga-ongkir").text(harga);
        var total = 
            @if (session()->has('voucher'))
                {{$total - session()->get('voucher')['value']}}
            @else
                {{$total}}
            @endif 
            + harga;
        $(".harga-total").text(total);
    }



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        }
    });

    $('#cek_voucher').click(function() {
        let serializeData  = { kode: $('#kode_voucher').val() };
        $.post('{{ route("checkout.voucher") }}', serializeData, function (data) {
            if(data.status!=0){
                var total = $(".harga-total").text();
                console.log(total);
                console.log(data.voucher['value']);
                total = total - data.voucher['value'];
                $(".harga-total").text(total);
                $(".voucher .alert").empty();
                html = `<div class="alert alert-info">
                            `+data.pesan+`
                        </div>`
                $(".voucher .pesan").append(html);
            }
        })
    })

    $('form.bill-detail').submit(function () {
        if($(".harga-ongkir").text() == 0){
            alert("Jasa Pengiriman Belum Dipilih")
            return false;
        };
    });
});
</script>
@endpush