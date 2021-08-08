@extends('layouts.admin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-900">Post</h1>
        <a href="{{ route('post.create') }}" class="btn btn-primary mb-4">Create a post</a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Post</h6>
            </div>
            <div class="card-body">
                
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection