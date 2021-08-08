@extends('layouts.app')


@section('content')

    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <a href="{{ route('home')}}">Home</a> 
                    <span class="mx-2 mb-0">/</span> 
                    <strong class="text-black">Detail Blog</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        
        <div class="row mt-4 mb-4 ml-4 mr-4 text-black">
            <div class="col-12">
                
                    <div class="card shadow border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    @foreach($blog as $item)
                                        <h1 class="text-center">{{ $item->title }}</h1>
                                        <div class="text-center">
                                            <img src="{{ asset('library/blog/'.$item->image)}}" style="mx-auto d-block" alt="">
                                        </div>
                                        <p>{!! $item->content !!}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <small class="text-muted">oleh {{ $item->user->fullname}}, {{ date('d F Y H:i',strtotime($item->publishedAt)) }}</small>
                            <small>
                                Tag: 
                                @foreach($tags as $itemTag)
                                                {{$itemTag->name}},
                                            @endforeach
                            </small>
                        </div>
                    </div>
                
            </div>
        </div>
      
    </div>
@endsection
