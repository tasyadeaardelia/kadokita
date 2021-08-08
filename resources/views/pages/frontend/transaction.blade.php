@extends('layouts.admin')

@section('title')
    Penjualan Toko
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-10">
                <h1 class="h3 mb-2 text-gray-900">Riwayat Penjualan Produk</h1>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row d-flex justify-content-between">
                    <h6 class="mt-2 ml-4 font-weight-bold text-primary">Tabel Penjualan Produk</h6>
                     <div class="mr-4" id="export"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example" width="100%" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Pembeli</th>
                                <th>Produk</th>
                                <th>Status Transaksi</th>
                                <th>Status Pengiriman</th>
                                <th>Resi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions_details as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->transaction->code }}</td>
                                    <td>{{ $item->transaction->user->fullname }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->transaction->transaction_status }}</td>
                                    <td>{{ $item->shipping_status }}</td>
                                    <td>{{ $item->resi}}</td>
                                    <td>{{ date('d F Y H:i',strtotime($item->transaction->transaction_date))}}</td>
                                    <td>
                                        <a href="{{ route('transaction.show',$item->id) }}" class="btn btn-outline-primary mr-4">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
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
                        title: 'Laporan Penjualan',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
