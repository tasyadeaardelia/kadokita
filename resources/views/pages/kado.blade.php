@extends('layouts.app')

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <a href="{{ route('home') }}">Home</a> 
                    <span class="mx-2 mb-0">/</span> 
                    <strong class="text-black">Shop</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-9 order-2">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4">
                                <h2 class="text-black h5">Semua Produk</h2>
                            </div>
                            <div class="float-right">
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                        <a class="dropdown-item">Relevance</a>
                                        <a class="dropdown-item" href="{{ route('shop-filter-asc', 'asc')}}">Nama, A to Z</a>
                                        <a class="dropdown-item" href="{{ route('shop-filter-asc', 'dsc')}}">Nama, Z to A</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('shop-filter-asc', 'lowest')}}">Harga, low to high</a>
                                        <a class="dropdown-item" href="{{ route('shop-filter-asc', 'highest')}}">Harga, high to low</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        @forelse($products as $product)
                            <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                <div class="block-4 text-center border">
                                    <figure class="block-4-image">
                                        <a href="{{ route('detail.product', $product->slug)}}">
                                            <img src="{{ asset('library/products/'.$product->photo)}}" alt="Image placeholder" class="img-fluid">
                                        </a>
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="{{ route('detail.product', $product->slug)}}">{{ $product->name }}</a></h3>
                                        <p class="text-primary font-weight-bold">Rp. {{ $product->price }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-sm-12 col-lg-12 mb-2 text-center" data-aos="fade-up">
                                <h5 class="text-warning">Maaf, produk belum ada </h5>
                            </div>
                        @endforelse
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-md-12 text-center">
                            <div class="site-block-27">
                                {{ $products->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                        <ul class="list-unstyled mb-0">
                            @forelse($categories as $item)
                                <li class="mb-1">
                                    <a href="{{ route('shop-filter-category', $item->slug) }}" class="d-flex">
                                        <span>{{ $item->name }}</span> 
                                        @foreach($count as $c)
                                            @if($c->category_id === $item->id)
                                                <span class="text-black ml-auto">({{ $c->hitung }})</span>
                                            @endif
                                        @endforeach
                                    </a>
                                </li>
                            @empty
                                <li class="mb-1 text-center">Kategori belum ada</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="border p-4 rounded mb-4">
                        
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                            <form method="post" action="{{ route('shop-filter-price') }}">
                                @csrf
                                <input type="text" hidden name="store_id" value="{{ $item->id }}">
                                <select name="filter_by_price" class="form-control" id="">
                                    <option value="">Pilih Harga</option>
                                    <option value="100000">Rp0 - Rp100.000</option>
                                    <option value="200000">Rp100.000 - Rp200.000</option>
                                    <option value="300000">Rp200.000 - Rp300.000</option>
                                    <option value="500000">Rp300.000 - Rp500.000</option>
                                </select>
                                
                                <button class="btn btn-sm btn-primary form-control mt-4" type="submit">Filter</button>
                                
                            </form>
                        </div>
                        
                    </div>

                    <div class="border p-4 rounded mb-4">
                        
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Locations</h3>
                            <form method="post" action="{{ route('shop-filter-location') }}">
                                @csrf
                                
                                    <select name="filter_by_location" class="form-control" id="">
                                       
                                        <option value="">Pilih Lokasi</option>
                                        @foreach($provinces as $province => $value)
                                        <option value="{{ $province}}">{{ $value}}</option>
                                        @endforeach
                                    </select>
                                
                                
                                <button class="btn btn-sm btn-primary form-control mt-4" type="submit">Filter</button>
                                
                            </form>
                        </div>
                        
                    </div>

                </div>
            </div>

            @include('includes.app.category')
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mb-lg-0 text-center" data-aos="fade" data-aos-delay="">
                    <a href="{{ route('category') }}" class="btn btn-outline-primary">More</a>
                </div>
            </div>
        </div>
    </div>
@endsection

