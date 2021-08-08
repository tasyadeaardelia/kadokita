@extends('layouts.admin')

@section('title', 'Manajemen Toko - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-4 text-gray-900">Permintaan Verifikasi Toko</h1>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row d-flex justify-content-between">
                    <h6 class="mt-2 ml-4 font-weight-bold text-primary"></h6>
                    <div class="mr-4" id="export"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example" width="100%" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Toko</th>
                                <th>Tanggal Bergabung</th>
                                <th>Nama Pemilik</th>
                                <th>Disetujui / Tidak Disetujui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stores as $store)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ date('d F Y H:s:i', strtotime($store->created_at)) }}</td>
                                    <td>{{ $store->user->fullname }}</td>
                                    <td>
                                        @if($store->is_approved == 0)
                                            Belum Disetujui
                                        @else
                                            Sudah Disetujui
                                        @endif
                                    </td>
                                    <td>
                                        @if($store->url != null)
                                            <a href="{{ route('show-store-to-approved', $store->url) }}" class="btn btn-outline-primary mr-4">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            Belum dapat melakukan apapun, nama dan url toko belum dilengkapi
                                        @endif
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
                        title: 'Post Table Datatables'
                    }
                ]
            });

            table.buttons(0, null).containers().appendTo('#export');
        });

    </script>
@endsection