@extends('layouts.admin')

@section('title', 'Detail Post - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Post</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('post.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        @foreach($data as $item)
                            <h1 class="text-center">{{ $item->title }}</h1>
                            <div class="text-center">
                                <img src="{{ asset('library/blog/'.$item->image)}}" style="mx-auto d-block" alt="">
                            </div>
                            <p class="mt-4">
                                Tag : 
                                @foreach($tags as $itemTag)
                                    {{$itemTag->name}},
                                @endforeach
                            </p>
                            <p>{!! $item->content !!}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection