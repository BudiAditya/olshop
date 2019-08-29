@extends('frontend.part.template')

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{ asset('frontend//img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Cart
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th width="15%">Quantity</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                @guest

                                    <?php  $total = 0; ?>
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $product)
                                        <?php $total += $product['harga'] * $product['quantity'] ?>

                                            <tr>
                                                <td>
                                                    <img src="{{ asset('frontend/img/') }}/{{$product['gambar']}}" width="60">
                                                </td>
                                                <td>
                                                    {{$product['nama']}}<br>
                                                    <small>1000g</small>
                                                </td>
                                                <td>
                                                    Rp {{$product['harga']}}
                                                </td>
                                                <td>
                                                    <input class="vertical-spin update-cart" data-id="{{$id}}" type="text" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="{{$product['quantity']}}" name="vertical-spin">
                                                </td>
                                                <td>
                                                    Rp {{$product['harga'] * $product['quantity']}}
                                                </td>
                                                <td>
                                                    <a href="javasript:void" data-id="{{$id}}" class="text-danger remove-from-cart"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif

                                @else

                                    <?php  $total = 0; ?>
                                    @foreach($carts as $cart)
                                    <?php  $total += $cart->Produk->harga_jual * $cart->quantity; ?>

                                        <tr>
                                            <td>
                                                <img src="{{ asset('frontend/img/') }}/{{$cart->Produk->gambar}}" width="60">
                                            </td>
                                            <td>
                                                {{$cart->Produk->nama}}<br>
                                                <small>1000g</small>
                                            </td>
                                            <td>
                                                Rp {{$cart->Produk->harga_jual}}
                                            </td>
                                            <td>
                                                <input class="vertical-spin update-cart" data-id="{{$cart->product_id}}" type="text" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="{{$cart['quantity']}}" name="vertical-spin">
                                            </td>
                                            <td>
                                                Rp {{$cart->Produk->harga_jual * $cart['quantity']}}
                                            </td>
                                            <td>
                                                <a href="javasript:void" data-id="{{$cart->product_id}}" class="text-danger remove-from-cart"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach


                                @endguest
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <a href="shop.html" class="btn btn-default">Continue Shopping</a>
                    </div>
                    <div class="col text-right">
                        <div class="clearfix"></div>
                        <h6 class="mt-3">Total: Rp {{$total}}</h6>
                        <a href="checkout" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
@endsection


@push('js')
 
 
    <script type="text/javascript">
 
        $(".update-cart").change(function (e) {
           e.preventDefault();
 
           var ele = $(this);
 
            $.ajax({
               url: "{{ route('cart.edit') }}",
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
 
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
 
            var ele = $(this);
 
            if(confirm("Are you sure")) {
                $.ajax({
                    url: "{{ route('cart.hapus') }}",
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
 
    </script>
 
@endpush