@extends('layouts.app')

@section('content')
    <div id="carouselExampleIndicators" class="container carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            @foreach($banner as $item)
                @if($item->active == true)
                    <div class="carousel-item active">
                        <img src="{{ asset('library/banner/'.$item->file)}}" class="d-block w-100" alt="...">
                    </div>
                @else
                    <div class="carousel-item">
                        <img src="{{ asset('library/banner/'.$item->file)}}" class="d-block w-100" alt="...">
                    </div>
                @endif
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="site-section site-section-sm site-block-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade up" data-aos-delay="">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-gift"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Temukan Kado</h2>
                        <p>Gunakan fitur dan layanan ini untuk menemukan kado yang cocok untuk mereka   </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon mr-4 align-selft-start">
                        <span class="icon-shop">
                        </span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">
                            Mulai Berjualan
                        </h2>
                        <p>
                            Kamu juga dapat menjadi penjual, yuk daftar dan atur toko kamu sendiri
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-check"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Selamat Menikmati Layanan</h2>
                        <p>
                            Nikmati Aplikasi ini yaa..
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.app.category')
    
    <div class="row mb-4">
        <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mb-lg-0 text-center" data-aos="fade" data-aos-delay="">
            <a href="{{ route('category') }}" class="btn btn-outline-primary">More</a>
        </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Featured Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @forelse($products as $product)
                            <div class="item">
                                <div class="block-4 text-center">
                                    <figure class="block-4-image">
                                        <img src="{{ asset('library/products/'.$product->photo) }}" alt="Image placeholder" class="img-fluid">
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3>
                                            <a href="{{ route('detail.product', $product->slug)}}">{{ $product->name }}</a>
                                        </h3>
                                        <p class="text-primary font-weight-bold">{{ $product->price }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Belum ada product</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section block-8">
        <div class="container">
            <div class="row justify-content-center  mb-5">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Blog</h2>
                </div>
            </div>
            <div class="row align-items-center">
                @forelse($blog_posts as $item)
                <div class="col-md-12 col-lg-7 mb-5">
                    <a href="{{ route('detail-blog', $item->slug)}}">
                        <img src="{{ asset('library/blog/'.$item->image)}}" alt="Image placeholder" class="img-fluid rounded">
                    </a>
                </div>
                <div class="col-md-12 col-lg-5 text-center pl-md-5">
                    <h2>
                        <a href="{{ route('detail-blog', $item->slug)}}">{{ $item->title }}</a>
                    </h2>
                    <p class="post-meta mb-4">By 
                        <a href="{{ route('detail-blog', $item->slug)}}">{{ $item->user->fullname }}</a> 
                        <span class="block-8-sep">&bullet;</span> {{ date('d F Y H:i',strtotime($item->publishedAt)) }}
                    </p>
                    <p>
                        @php
                        echo substr(strip_tags($item->content),0,300)."..................";    
                      @endphp
                    </p>
                    <p>
                        <a href="{{ route('detail-blog', $item->slug)}}" class="btn btn-outline-info">
                           
                            Baca</a>
                    </p>
                </div>
                @empty
                    <div class="col-lg-12 col-12">
                        <p class="text-center">Belum ada blog</p>
                    </div>

                @endforelse
            </div>
        </div>
    </div>
@endsection