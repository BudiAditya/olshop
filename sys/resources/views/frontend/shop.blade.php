@extends('frontend.part.template')

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{ asset('frontend/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        Shopping Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="Shop">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Shop</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <form action="{{ url()->current() }}">
                            <h5>Sorting</h5>
                            <select name="order_by" id="sorting" class="form-control">
                                <option value="terbaru"  <?php if(request()->get('order_by')=="terbaru"){ echo "selected"; } ?>>Default</option>
                                <option value="termurah" <?php if(request()->get('order_by')=="termurah"){ echo "selected"; } ?>>Termurah</option>
                                <option value="termahal" <?php if(request()->get('order_by')=="termahal"){ echo "selected"; } ?>>Termahal</option>
                            </select>


                            <br>
                            <h5>Search</h5>
                            Cari
                            <input type="text" name="keyword" class="form-control mb-2" value="{{ request()->get('keyword') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form>
                    </div>

                    <div class="col-md-9">
                        <div class="row" id="produk">
                            @foreach ($products as $product)
                            <div class="col-md-3 mb-4">
                                <div class="item">
                                    <div class="card card-product">
                                    @if (!empty($product->tag_id))
                                        <div class="card-ribbon">
                                            <div class="card-ribbon-container right">
                                                <span class="ribbon ribbon-{{$product->Tag->tag_warna}}">{{$product->Tag->tag_nama}}</span>
                                            </div>
                                        </div>
                                    @endif
                                        <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                {{$product->Kategori->kategori_nama}}
                                            </span>
                                        </div>
                                            <img src="gambar_produk/{{$product->gambar}}" alt="Card image 2" class="card-img-top">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <a href="detail-produk/{{$product->id}}">{{$product->nama}}</a>
                                            </h4>
                                            <div class="card-price">
                                                <!-- <span class="discount">Rp. 300.000</span> -->
                                                <span class="reguler">Rp {{ number_format($product->harga_jual, 0, ',', '.')}}</span>
                                            </div>
                                            <a href="{{ route('cart.tambah', ['id' => $product->id] ) }}" class="btn btn-block btn-primary">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                
                </div>
                

            </div>
        </section>
@endsection
