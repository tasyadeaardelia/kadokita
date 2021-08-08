<div class="site-section site-blocks-2">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Kategori</h2>
            </div>
        </div>
        
        <div class="row mt-4 mb-4">
            @forelse($categories as $item)
                @php $i=1; @endphp
                @if($i%2 == 0)
                    <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                        <a href="{{ route('detail-category', $item->slug)}}" class="block-2-item">
                            <figure class="image">
                                <img src="{{ asset('library/category/'.$item->cover) }}" alt="" class="img-fluid">
                            </figure>
                            <div class="text">
                                <span class="text-uppercase">Moment</span>
                                <h3>{{ $item->name }}</h3>
                            </div>
                        </a>
                    </div>
                @endif
                @php $i+=1; @endphp
                @empty
                <div class="col-sm-12 col-md-12 col-lg-12 mt-4 mb-4 mb-lg-0 text-center" data-aos="fade" data-aos-delay="">
                    <p>Kategori Masih Kosong</p>
                </div>
            @endforelse
        </div>
    
    
        <div class="row mt-4 mb-4">
            @forelse($categories as $item)
                @php $i=1; @endphp
                @if($i%2 != 0)
                    <div class="col-sm-6 col-md-6 col-lg-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                        <a href="{{ route('detail-category', $item->slug)}}" class="block-2-item">
                            <figure class="image">
                                <img src="{{ asset('library/category/'.$item->cover) }}" alt="" class="img-fluid">
                            </figure>
                            <div class="text">
                                <span class="text-uppercase">Moment</span>
                                <h3>{{ $item->name }}</h3>
                            </div>
                        </a>
                    </div>
                @endif
                @php $i+=1; @endphp
                @empty
                <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mb-lg-0 text-center" data-aos="fade" data-aos-delay="">
                    <p>Kategori Masih Kosong</p>
                </div>
            @endforelse
        </div>

    </div>
</div>