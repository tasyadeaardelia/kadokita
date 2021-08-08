@extends('layouts.admin')

@section('title', 'Post - Index')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Post Blog</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('post.create') }}" class="btn btn-primary mb-4">Tulis Blog</a>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row d-flex justify-content-between">
                    <h6 class="mt-2 ml-4 font-weight-bold text-primary">Tabel Post</h6>
                     <div class="mr-4" id="export"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Post</th>
                                <th>Author</th>
                                <th>Tanggal Terbit</th>
                                <th>Status</th>
                                <th>Tanggal Buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->user->fullname }}</td>
                                    <td>{{ $item->publishedAt}}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->created_at}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
                                                <a href="{{ route('post.show',$item->id) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="col-3">
                                                <a href="{{ route('post.edit',$item->id) }}" class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="col-3">
                                                <form action="{{ route('post.destroy',$item->id) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data masih kosong
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script-datatables')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable();

            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: 'Laporan Blog Post KadoKita',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        customize: function(doc) {
                            doc.pageMargins = [50, 40, 40, 50]; 
                        }
                    }
                ]
            });

            table.buttons(0, null).containers().appendTo('#export');
        });

    </script>
@endsection

