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
                        Cek Pesanan
                    </h1>
                    <p class="lead">
                        Cek Status Pesanan / Pengirimankamu disini
                    </p>
                </div>
            </div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <form method="post">
                            <div class="form-group">
                                <label for="no_pesanan">No Pesanan</label>
                                <input type="text" class="form-control" id="no_pesanan" name="no_pesanan" placeholder="Masukan No Pesanan">
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan No HP">
                            </div>
                            <button class="btn btn-primary" type="button" id="cekpesanan">Cek Pesanan</button>
                        </form>
                    </div>

                    <div class="col-md-9 col-12 mt-4">
                        <div class="status-pesanan"></div>
                        <div class="alert alert-info">
                            <h5>Peringatan</h5>
                            <ul>
                                <li>Jangan main klarinet.</li>
                                <li>Jangan pakai baju bodoh.</li>
                                <li>Jangan pakai rok panjang.</li>
                                <li>Jangan pakai sepatu merah.</li>
                                <li>Jangan berlagak seperti kera.</li>
                                <li>Jangan lari.</li>
                                <li>Jangan jalan pincang.</li>
                                <li>Jangan merangkak.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
@push('js')
<script>
    $('#cekpesanan').click(function(){
        serializeData = {
            _token: '{{ csrf_token() }}',
            no_pesanan : $('#no_pesanan').val(),
            no_hp : $('#no_hp').val()
        };
        $.post('{{ route("cek.pesanan.post") }}', serializeData, function (data) {
            detail_produk_html = "";
            total = 0;

            if(jQuery.isEmptyObject(data) !== true){
                $.each(data.transaksi_detail, function(key, value){
                    total += value.quantity * value.harga_jual;
                    detail_produk_html += `<tr class="detail-produk">
                                                <td>`+value.quantity+`</td>
                                                <td>`+value.produk.nama+`</td>
                                                <td>@</td>
                                                <td>Rp `+ ( value.quantity * value.harga_jual ) +`</td>
                                            </tr>
                                            `;
                })

                if( data.voucher == null) { data.voucher = 0 };
                html = `
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h6>FAKTUR #INV`+data.transaksi_id+`</h6>
                                        <hr>
                                        <small>2019-07-08 09:18:24</small> <br>
                                        <span class="nama-lengkap font-weight-bold">`+data.alamat.nama_depan+`</span> <br>
                                        <span class="alamat">`+data.alamat.alamat+`</span> <br>
                                        <span class="kecamatan">`+data.alamat.kecamatan+`</span> <br>
                                        <span class="kota">Kota `+data.alamat.kota+`</span> <br>
                                        <span class="provinsi">`+data.alamat.provinsi+`,</span>
                                        <span class="kode-pos"> `+data.alamat.kode_pos+`</span>
                                        <br><br>
                                        <div class="card">
                                            <div class="card-body pt-3">
                                                <img src="frontend/img/kurir/`+data.kurir+`.png" class="img-responsive float-left" width="120" alt="">
                                                <strong class="kurir-title">`+data.kurir+`</strong> <br>
                                                `+data.kurir_service+`
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <h6>Produk</h6>
                                        <hr>
                                        <table class="table table-striped m-0">
                                            `+detail_produk_html+`
                                        </table>
                                        <table class="table table-borderless">
                                            <tr class="detail-produk border-top">
                                                <td></td>
                                                <td class="text-right pr-2">Sub Total</td>
                                                <td>:</td>
                                                <td>Rp `+total+`</td>
                                            </tr>
                                            <tr class="detail-produk">
                                                <td></td>
                                                <td class="text-right pr-2">Ongkos Kirim</td>
                                                <td>:</td>
                                                <td>Rp `+ ( data.total_transaksi - total ) +`</td>
                                            </tr>
                                            <tr class="detail-produk">
                                                <td></td>
                                                <td class="text-right pr-2">Voucher</td>
                                                <td>:</td>
                                                <td>Rp `+data.voucher+`</td>
                                            </tr>
                                            <tr class="detail-produk">
                                                <td></td>
                                                <td class="text-right pr-2">Kode Unik</td>
                                                <td>:</td>
                                                <td>`+data.kode_unik+`</td>
                                            </tr>
                                            <tr class="detail-produk">
                                                <td class="bg-info"></td>
                                                <td class="bg-info text-right pr-2">Total</td>
                                                <td class="bg-info">:</td>
                                                <td class="bg-info font-weight-bold">Rp `+ (parseInt(data.total_transaksi) + parseInt(data.kode_unik) - parseInt(data.voucher) )+`</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <h6>Detail</h6>
                                        <hr>
                                        <div class="text-center">
                                            <div class="text-left">
                                                <strong>Status :</strong>
                                                <span class="text-info">`+data.status_pembayaran+`</span> <br>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-left">
                                                <strong>Status Transaksi:</strong>
                                                <span class="text-info">`+data.status_transaksi+`</span> <br>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>`;
            }else{
                html = `<div class="alert alert-error">
                            Data tidak Ditemukan
                        </div>`;
            }
            $(".status-pesanan").empty();
            $(".status-pesanan").append(html);
        })
    });
</script>
@endpush