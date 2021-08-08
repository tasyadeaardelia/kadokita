@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid">
        @if($store->is_approved == 0)
            <div class="row d-flex justify-content-center">
                <div class="card shadow mt-4 mb-4">
                    <div class="card-body text-danger">
                        Maaf Kamu belum dapat menambahkan produk, tunggu admin konfirmasi toko kamu dulu yaa.
                    </div>
                </div>
            </div>
        @else 
        
            <div class="row">
                <div class="col-10">
                    <h1 class="h3 mb-2 text-gray-900">Tambah Produk</h1>
                </div>
                <div class="col-2">
                    <a href="{{ route('product.index') }}" class="btn btn-primary mb-4">Kembali</a>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Baru</h6>
                </div>
                <div class="card-body">
                    <form method="post" enctype='multipart/form-data' action="{{ route('product.store')}} ">
                        @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nama Produk</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Harga Produk</label>
                                <div class="col-lg-9">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="number" name="price" class="form-control" placeholder="Harga" aria-label="Harga" aria-describedby="basic-addon1" required value="{{ old('price')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Berat</label>
                                <div class="col-lg-9">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Gram</span>
                                        </div>
                                        <input type="number" name="weight" class="form-control" placeholder="Berat" aria-label="Berat" aria-describedby="basic-addon1" required value="{{ old('weight')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Stok</label>
                                <div class="col-lg-9">
                                    <input type="number" name="stock" class="form-control" required value="{{ old('stock')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Upload Gambar</label>
                                <div class="col-lg-9">
                                    <input type="file" name="photo" required accept="image/*" onchange="showPreview(event);">
                                    <div class="preview-img">
                                        <img id="preview">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Deskripsi Singkat</label>
                                <div class="col-lg-9">
                                    <textarea name="description" id="elm1" value="{{ old('elm1') }}" class="form-control" ></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h4 class="col-lg-3 col-form-label form-control-label">Klasifikasikan Produk Kamu</h4>
                            </div>

                            <fieldset class="form-group row">
                                <legend class="col-form-label col-lg-3 float-sm-left pt-0">Cocok Untuk</legend>
                                <div class="col-lg-9">
                                    @foreach($category as $item)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="category[]" value="{{ $item->id }}">
                                            <label class="form-check-label" for="gridCheck1">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <input class="btn btn-danger" type="reset" value="Reset">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script-tinymce')
    <script src="{{ asset('backend/vendor/tinymce/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            if($("#elm1").length > 0){
                tinymce.init({
                    selector: "textarea#elm1",
                    theme: "modern",
                    height:300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ]
                });
            }
        });
    </script>
@endsection

