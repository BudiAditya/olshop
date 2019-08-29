@extends('frontend.part.template')

@push('css')
<style>
.share i{
    border: 2px solid currentColor;
    background-color: transparent;
    padding: 8px;
    margin: 2px;
    border-radius: 999px;
}
</style>
@endpush

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{ asset('frontend/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        {{$products->nama}}
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="slider-zoom">
                            <a href="{{ asset('gambar_produk').'/'.$products->gambar }}" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                                <img alt="Detail Zoom thumbs image" src="{{ asset('gambar_produk').'/'.$products->gambar }}" style="width: 100%;">
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Deskripsi</strong><br>
                            {{$products->deskripsi}}
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/{{$products->Satuan->satuan_nama}})<br>
                                    <span class="price">Rp {{$products->harga_jual}}</span>
                                    <!-- <span class="old-price">Rp 150.000</span> -->
                                </p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <p>
                                    <span class="stock available">Berat : ({{$products->berat}} gram)</span>
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('cart.tambah', ['id' => $products->id] ) }}" class="mt-3 btn btn-primary btn-lg">
                            <i class="fa fa-shopping-basket"></i> Add to Cart
                        </a>
                    </div>
                    <div class="offset-md-1 col-sm-1 text-center">
                        <strong>Share</strong>
                        <ul class="list-unstyled share">
                            <li><a><i class="fab fa-facebook"></i></a></li>
                            <li><a><i class="fab fa-twitter"></i></a></li>
                            <li><a><i class="fab fa-google"></i></a></li>
                            <li><a><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Review</h4>
                        <strong>Belum ada review saat ini</strong>
                    </div>
                </div>
            </div>
        </div>


        <section id="related-product">
            <div class="container">
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Related Products</h2>
                        <div class="related-product-carousel owl-carousel">
                            @foreach ($relatedproducts as $relatedproduct)
                            <div class="item">
                                <div class="card card-product">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until 2018
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="{{ asset('gambar_produk') }}/{{$relatedproduct->gambar}}" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.html">{{$relatedproduct->nama}}</a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">Rp {{$relatedproduct->harga_jual}}</span>
                                        </div>
                                        <a href="detail-product.html" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection