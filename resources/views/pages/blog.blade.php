@extends('layouts.app')

@section('content')

    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <a href="{{ route('home')}}">Home</a> 
                    <span class="mx-2 mb-0">/</span> 
                    <strong class="text-black">Blog</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @forelse($blog as $item)
        <div class="row mt-4 mb-4 ml-4 mr-4 text-black">
            <div class="col-12">
                <a href="{{ route('detail-blog', $item->slug)}}" class="text-black">
                    <div class="card shadow border">
                        <div class="card-horizontal">
                            <div class="img-square-wrapper">
                                <img class="" src="{{ asset('/library/blog/'.$item->image)}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">{{ $item->title }}</h4>
                                <p class="card-text">
                                    @php
                                        echo substr(strip_tags($item->content),0,300)."..................";    
                                    @endphp
                                </p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">oleh {{ $item->user->fullname}}, {{ date('d F Y H:i',strtotime($item->publishedAt)) }}</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="row mt-4 mb-4 ml-4 mr-4 text-center">
            <h4>Maaf, Belum ada Blog / Artikel Untuk saat ini</h4>
        </div>
        @endforelse
    </div>
@endsection

@push('addon-style')
<style>
    .card{
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
      transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
    /* padding: 14px 80px 18px 36px; */
    cursor: pointer;
    }

    .card:hover{
        transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    color: black;
    }

    .card-horizontal {
    display: flex;
    flex: 1 1 auto;
    }
</style>
@endpush