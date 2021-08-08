@extends('layouts.admin')

@section('title', 'Tambah Kategori - Admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-10 col-6">
                <h1 class="h3 mb-2 text-gray-900">Tambah Kategori Baru</h1>
            </div>
            <div class="col-lg-2 col-6">
                <a href="{{ route('category.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Kategori</h6>
            </div>
            <div class="card-body">
                <form method="post" enctype='multipart/form-data' action="{{ route('category.store')}} ">
                    @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Nama Kategori</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Deskripsi</label>
                            <div class="col-lg-9">
                                <textarea name="description" class="form-control" value="{{ old('description') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="sampul-kategori">Sampul</label>
                            <div class="col-lg-9">
                                <input type="file" id="sampul-kategori" name="cover" accept="image/*" onchange="showPreview(event);">
                                <div class="preview-img">
                                    <img id="preview">
                                </div>
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