@extends('layouts.admin')

@section('title', 'Edit Post - Admin')

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-10">
                    <h1 class="h3 mb-2 text-gray-900">Edit Blog</h1>
                </div>
                <div class="col-2">
                    <a href="{{ route('post.index') }}" class="btn btn-primary mb-4">Kembali</a>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Post</h6>
                </div>
                <div class="card-body">
                    <form method="post" enctype='multipart/form-data' action="{{ route('post.update', $post->id)}} ">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Judul</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="title" required value="{{ $post->title }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Isi / Konten</label>
                            <div class="col-lg-9">
                                <textarea name="content" id="elm1">{{ $post->content }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Tag</label>
                            <div class="col-lg-9">
                                <input type="text" data-role="tagsinput" name="tags" class="form-control tags" value="
                                    @for($i=0; $i<count($tag); $i++)
                                        {{ $tag[$i]['name'].","}}
                                    @endfor
                                ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="sampul-post">Sampul Post</label>
                            <div class="col-lg-9">
                                <input type="file" id="sampul-post" name="image" accept="image/*" onchange="showPreview(event);">
                                <div class="preview">
                                    <img id="sampul-post-preview">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Tanggal Terbit</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="publishedAt" type="datetime-local" value="{{$post->publishedAt}}" id="example-datetime-local-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Status</label>
                            <div class="col-lg-9">
                                <select name="status" required class="form-control" id="">
                                    <option value="">Pilih status untuk post ini</option>
                                    @foreach($values as $value)
                                    <option value="
                                        @if ($value === 'aktif')
                                            Aktif
                                        @elseif ($value === 'draft')
                                            Draft
                                        @endif
                                    ">
                                        @if ($value === 'aktif')
                                            Aktif
                                        @elseif ($value === 'draft')
                                            Draft
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-danger" type="reset" value="Reset">
                            <button class="btn btn-primary" type="submit">Update</button>   
                        </div>
                    </form>
                </div>
            </div>

        </div>
    <!-- /.container-fluid -->
@endsection

@section('script-tags-input')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
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