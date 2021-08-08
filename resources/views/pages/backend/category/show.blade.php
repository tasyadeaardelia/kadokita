@extends('layouts.admin')

@section('title', 'Detail Kategori - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-10 col-6">
                <h1 class="h3 mb-2 text-gray-900">Detail Kategori</h1>
            </div>
            <div class="col-lg-2 col-6">
                <a href="{{ route('category.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                
            </div>
            <div class="card-body table-responsive">
               <table class="table">
                   @foreach($category as $item)
                    <tr>
                        <th>Nama Kategori</th>
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $item->slug }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $item->description }}</td>
                    </tr>
                    <tr>
                        <th>Sampul Kategori</th>
                        <td>
                            <img src="{{ asset('library/category/'.$item->cover)}}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat pada tanggal</th>
                        <td>{{ $item->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Terakhir di update</th>
                        <td>{{ $item->updated_at }}</td>
                    </tr>
                   @endforeach
               </table>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection