@extends('layouts.app')

@section('content')
        <!-- Header-->
        <header class=" py-5" style="background-color: #136772;
        background-image: linear-gradient(315deg, #ff41f6 0%, hsla(202, 58%, 64%, 0.78) 74%);">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">{{ $category->name }}</h1>
                    <p class="lead fw-normal text-white-50 mb-0">{{ $category->description }}</p>
                </div>
            </div>
        </header>  

        <div class="site-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-9 order-2">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="float-md-left">
                                    <h2 class="text-black h5">Semua Produk</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            @forelse($detailcategory as $detail)
                                <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                    <div class="block-4 text-center border">
                                        <figure class="block-4-image">
                                            <a href="">
                                                <img src="{{ asset('library/products/'.$detail->photo)}}" alt="Image placeholder" class="img-fluid">
                                            </a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="{{ route('detail.product', $detail->slug )}}">{{ $detail->name }}</a></h3>
                                            <p class="text-primary font-weight-bold">Rp. {{ $detail->price}}</p>
                                            <p class="text-primary">Stok : {{ $detail->stock }}</p>
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
                                    {{ $detailcategory->links("pagination::bootstrap-4") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 order-1 mb-5 mb-md-0">
                        <div class="border p-4 rounded mb-4">
                            
                            <div class="mb-4">
                                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                                <form method="post" action="{{ route('category-filter-price') }}">
                                    @csrf
                                    <input type="text" hidden name="slug" value="{{ $category->slug }}">
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
                    </div>
                </div>

            
            </div>
        </div>
       

@endsection


