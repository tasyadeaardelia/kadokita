@extends('layouts.app')

@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('home')}}">Home</a> <span class="mx-2 mb-0">/</span> 
                <strong class="text-black">{{ $product->name }}</strong>
            </div>
        </div>
    </div>
</div>

@if (session('failed'))
<div class="alert alert-danger ml-4 mr-4 mt-4">
    {{ session('failed') }}
</div>
@endif

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('library/products/'.$product->photo)}}" alt="">
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('detail.addToCart', $product->id)}}" enctype="multipart/form-data">
                    @csrf
                    <h2 class="text-black">{{ $product->name }}</h2>
                    <p>{!! $product->description !!}</p>
                    <p><strong class="text-primary h4">{{ $product->price }}</strong></p>
                    <p>Stok : <strong class="">{{ $product->stock }}</strong></p>
                    <div class="mb-5">
                        <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center" name="quantity" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>
                    </div>
                    <p>
                        @if($product->stock)
                            <button type="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button>
                        @endif
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container card shadow border-black">
        <div class="row card-body mt-4 mb-4">
            <div class="col-lg-2">
                <div class="circular--landscape">
                    <img src="{{ asset('library/store/'.$product->store->profil)}}" alt="">
                </div>
            </div>
            <div class="col-lg-4" style="margin-left: -50px;">
                <h6 class="text-black">{{ $product->store->name}}</h6>
                <a class="btn btn-white border-success" href="{{ route('detail-store', $product->store->url)}}">
                    <i class="fas fa-store"></i>
                    Kunjungi Toko
                </a>
            </div>
            <div class="col-lg-5">
                <div class="row d-flex justify-content-between">
                    <div class="col-5">
                        <p>Produk</p>
                        <p>Bergabung Sejak</p>
                        <p>Lokasi</p>
                    </div>
                    <div class="col-5" style="margin-left: -150px;">
                        <p>{{ $countproduct }}</p>
                        <p>{{ $diff->d }} hari lalu</p>
                        <p>{{ $product->store->user->city->title }}, {{ $product->store->user->province->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section block-3 site-blocks-2 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Kado Lainnya</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nonloop-block-3 owl-carousel">
                    @foreach($detailproduct as $item)
                    <div class="item">
                        <div class="block-4 text-center">
                            <figure class="block-4-image">
                                <img src="{{ asset('library/products/'.$item->product->photo) }}" alt="Image placeholder" class="img-fluid" data-pagespeed-url-hash="1414887416" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                            </figure>
                            <div class="block-4-text p-4">
                                <h3><a href="{{ route('detail.product', $item->product->slug)}}">{{ $item->product->name}}</a></h3>
                                <p class="mb-0">{{ $item->category->name}}</p>
                                <p class="text-primary font-weight-bold">{{ $item->product->price}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('prepend-style')
<link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

@endpush
@push('addon-style')
    <style>
        .circular--landscape {
        display: inline-block;
        position: relative;
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%;
    }
    
    .circular--landscape img {
        width: auto;
        height: 100%;
        margin-left: 0px;
    }
    </style>
@endpush