<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN PENJUALAN</title>

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body>
    <div class="container-fluid">
        <div class="dashboard-heading d-flex justify-content-between">
            <h5 class="dashboard-subtitle mt-2">
                Laporan Penjualan
            </h5>  
        </div>
        <div class="dashboard-content" id="transactionDetails">
            <table class="table table-striped table-bordered" width="100%" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pembeli</th>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Total Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status Transaksi</th>
                        <th>Status Pengiriman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->transaction->code}}</td>
                            <td>{{ $item->transaction->user->fullname }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->product->price}}</td>
                            <td>{{ $item->quantity}}</td>
                            <td>{{ $item->transaction->total_price}}</td>
                            <td>{{ date('d F Y H:i',strtotime($item->transaction->transaction_date)) }}</td>
                            <td>{{ $item->transaction->transaction_status}}</td>
                            <td>{{ $item->shipping_status }}</td>
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

</body>
</html>
