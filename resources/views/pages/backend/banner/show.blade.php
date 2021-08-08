@extends('layouts.admin')

@section('title', 'Detail Banner - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Detail Banner</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('banner.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                
            </div>
            <div class="card-body">
               <table class="table">
                   @foreach($banner as $item)
                    <tr>
                        <th>File</th>
                        <td>
                            <img src="{{ asset('library/banner/'.$item->file)}}" width="50%" alt="">
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($item->active == true)
                                Banner Utama
                            @else
                                Banner Lainnya
                            @endif
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