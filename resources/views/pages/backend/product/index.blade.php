@extends('layouts.admin')

@section('title', 'Product')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        {{-- 
            Cek jika user yang login punya toko yang belum diverifikasi, maka akan muncul tampilan pesan bahwa harus menunggu
            di verifikasi oleh admin
        --}}
        @if($store)
            @if($store->is_approved == 0)
                <div class="row d-flex justify-content-center" style="margin-top: 80px;">
                    <div class="card shadow mt-4 mb-4">
                        <div class="card-body text-danger">
                            Maaf Kamu belum dapat menambahkan produk, tunggu admin konfirmasi toko kamu dulu yaa.
                        </div>
                    </div>
                </div>
            @else

            <!-- Page Heading -->
            <div class="row">
                <div class="col-10">
                    <h1 class="h3 mb-2 text-gray-900">Produk</h1>
                </div>
                <div class="col-2">
                    <a href="{{ route('product.create') }}" class="btn btn-primary mb-4">Tambah Produk</a>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row d-flex justify-content-between">
                        <h6 class="mt-2 ml-4 font-weight-bold text-primary">Produk Saya</h6>
                        <div class="mr-4" id="export"></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" width="100%" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Berat</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>
                                            <a href="{{ route('product.show',$item->id) }}" class="btn btn-outline-primary mr-4">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('product.edit',$item->id) }}" class="btn btn-outline-warning mr-4">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('product.destroy',$item->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
            @endif
        @else
            <div class="row d-flex justify-content-center" style="margin-top: 80px;">
                <div class="card shadow mt-4 mb-4">
                    <div class="card-body text-danger">
                        Maaf Kamu belum dapat menambahkan produk, silahkan buka toko dulu yaa...
                    </div>
                </div>
            </div>
        @endif

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
                        title: 'Produk Saya'
                    }
                ]
            });

            table.buttons(0, null).containers().appendTo('#export');
        });

    </script>
@endsection