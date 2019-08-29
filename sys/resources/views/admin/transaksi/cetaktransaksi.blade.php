<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('frontend/packages/bootstrap/bootstrap.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <style>
    body{
        font-family: "Lato", "Helvetica Neue", Arial, sans-serif;
        font-size: 14px;
    }
    hr.dot {
        border-top: 2px dashed #dedede;
        height:1px;
        margin: 15px -25px 0;
    }
    .table td, .table th{
        padding: 0;
    }

    @media print
    {
        .rows-print{
            display: block;
        }
        .print{
            page-break-inside: avoid;
        }
    }
    </style>
</head>
<body>
    <div class="m-5"></div>

    <div class="container">
        <div class="row rows-print">
            @foreach($invoices as $invoice)
            <div class="col-6 mb-4 print">
                <div class="border bg-light p-4">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('img/logo.png') }}" alt="" width="200">
                            <hr class="m-0 mb-2">
                            No Pesanan : #INV{{$invoice->transaksi_id}}<br>
                            <br>
                            
                            Pengiriman :
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <img src="../../../frontend/img/kurir/{{$invoice->kurir}}.png" class="img-responsive float-left" width="120" alt="">
                                    <span class="text-uppercase font-weight-bold">{{$invoice->kurir.' '.$invoice->kurir_service}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <h6>Penerima</h6>
                            <span class="d-block">Teguh Rianto</span>
                            <span class="d-block">Jl. Petani No. 159, Cibabat</span>
                            <span class="d-block">Cimahi Utara, Kota Cimahi</span>
                            <span class="d-block">Jawa Barat, 40513</span>
                            <br>
                            <h6>Pengirim</h6>
                            <span>{{ config('setting.NamaToko') }}</span> <br>
                            <span>{{ config('setting.Telp') }}</span>
                        </div>
                    </div>
                    <hr class="mb-0 dot">
                    <small>Lipat Disini</small>
                    <h6  class="mt-2">Produk</h6>
                    <table class="table table-striped m-0">
                        <?php $total = 0; ?>
                        @foreach(\App\Model\TransaksiDetail::where('transaksi_id', $invoice->transaksi_id)->get() as $transaksi_detail)
                        <?php $total += $transaksi_detail->quantity * $transaksi_detail->harga_jual ?>
                        <tr class="detail-produk">
                            <td>{{ $transaksi_detail->quantity }}</td>
                            <td>{{ $transaksi_detail->Produk->nama }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @if($invoice->catatan)
                    <span>
                        Catatan : {{$invoice->catatan}}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
