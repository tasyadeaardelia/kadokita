@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Detail Produk</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('allproduct.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                
            </div>
            <div class="card-body table-responsive">
               <table class="table">
                   @foreach($product as $item)
                    <tr>
                        <th>Nama Produk</th>
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $item->slug }}</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>{{ $item->weight }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>{{ $item->price }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{!! $item->description !!}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $item->stock}}</td>
                    </tr>
                    <tr>
                        <th>Foto Produk</th>
                        <td>
                            <img src="{{ asset('library/products/'.$item->photo)}}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <th>Kategori Produk</th>
                        <td>
                            @foreach ($productcategory as $item)
                            {{ $item->category->name }},
                            @endforeach
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