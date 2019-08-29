@extends('frontend.part.template')

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{asset('frontend/img/bg-header.jpg')}}');">
                <div class="container">
                    <h1 class="pt-5">
                        Invoice
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="invoice">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6 col-12">
                        
                        <div class="card">
                            <div class="card-body text-center">
                                <h4>Selamat! <br> Pesanan anda berhasil dibuat!</h4>
                                <p>Silahkan Lakukan Pembayaran sebesar:</p>
                                <h1 class="text-primary" id="payment-sum" data-value="{{$transaksi->total_transaksi+$transaksi->kode_unik}}">Rp {{ number_format($transaksi->total_transaksi+$transaksi->kode_unik-$transaksi->voucher, 0, ',','.') }}</h1>

                                <div class="alert alert-info border">
                                    <strong>Transfer tepat sampai 2 digit terakhir</strong>
                                    <br>
                                    <span>Perbedaan nominal menghambat proses verifikasi</span>
                                </div>

                                <p>Transfer pembayaran ke nomor rekening :</p>
        
                                <div class="row eq-height mb-3">
                                    <div class="col-6 text-right border-right">
                                        <img src="https://ecs7.tokopedia.net/img/toppay/thanks/bca.png" alt="" width="90">
                                    </div>
                                    
                                    <div class="col-6 text-left">
                                        <strong>
                                        A/N &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ config('setting.NamaBCA') }} <br>
                                        Norek &nbsp;: <span id="payment-code" data-value="{{ config('setting.NorekBCA') }}">{{ config('setting.NorekBCA') }}</span>
                                        </strong>
                                    </div>
                                </div>
                            
                                <button onclick="copyToClipboard('#payment-sum')" class="btn btn-info btn-sm">Salin Jumlah</button>
                                <button onclick="copyToClipboard('#payment-code')" class="btn btn-success btn-sm">Salin no. Rek</button>

                                <hr>
                                <p class="text-muted">
                                    <strong>Pastikan pembayaran Anda sudah BERHASIL dan unggah bukti/konfirmasi untuk mempercepat proses verifikasi</strong>
                                </p>
                                <hr>

                                @if(Auth::user())
                                <a class="btn btn-primary py-2 w-100" href="{{ route('transaksi' ) }}">Cek Status Pembayaran</a>
                                @else
                                <a class="btn btn-primary py-2 w-100" href="{{ url('cekstatuspesanan') }}">Cek Status Pembayaran</a>
                                @endif
                            </div>
                        </div>

                        <br> 
                        
                        <div class="alert alert-warning">
                            Pastikan untuk tidak menginformasikan bukti dan data pembayaran <i>kepada pihak manapun</i> kecuali <a href="" class="alert-link">Kontak Kami</a>
                        </div>
                

                        <div class="secure-img">
                            <img src="{{ asset('img/LogoFooterTransfer.png') }}" class="img-responsive center-block" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
<script>
    function copyToClipboard(id) {
        var $tempElement = $("<input>");
        $("body").append($tempElement);
        $tempElement.val($(id).data('value')).select();
        document.execCommand("copy");
        $tempElement.remove();
        alert($(id).data('value')+" Telah di Salin");
    }
</script>
@endpush