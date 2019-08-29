@extends('frontend.part.template')

@section('content')
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('{{asset('frontend/img/bg-header.jpg')}}');">
                <div class="container">
                    <h1 class="pt-5">
                        Lupa Password
                    </h1>
                    <p class="lead">
                        Hemat waktu dan serahkan barang belanjaan kepada kami.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="email" type="text" required="" placeholder="Email" value="{{ old('email') }}" >
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">Lupa Password</button>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection