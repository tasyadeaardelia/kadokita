@extends('layouts.admin')

@section('title', 'Tambah Banner - Admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Tambah Banner Baru</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('banner.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Banner</h6>
            </div>
            <div class="card-body">
                <form method="post" enctype='multipart/form-data' action="{{ route('banner.store')}} ">
                    @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="sampul-Banner">File</label>
                            <div class="col-lg-9">
                                <input type="file" id="sampul-Banner" name="file" accept="image/*" onchange="showPreview(event);">
                                <div class="preview-img">
                                    <img id="preview">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="sampul-Banner">Status</label>
                            <div class="col-lg-9">
                                @if($banner->isEmpty())
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="active" value="1">
                                        <label class="form-check-label" for="gridCheck1">
                                            Utama
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="active" value="0">
                                        <label class="form-check-label" for="gridCheck1">
                                            Lainnya
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="active" value="0">
                                        <label class="form-check-label" for="gridCheck1">
                                            Lainnya
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-danger" type="reset" value="Reset">
                            <button class="btn btn-primary" type="submit">Submit</button>   
                        </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection