@extends('layouts.admin')

@section('title')
    Detail Transaksi
@endsection

@section('content')
<!-- Section Content -->
    <div class="container-fluid" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading d-flex justify-content-between">
                <h5 class="dashboard-subtitle mt-2">
                   Detail Transaksi
                </h5>  
                <h2 class="dashboard-title">#{{ $transactions_details->code }}</h2>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="background-color: rgb(204, 204, 238);">
                                    <div class="col-12 col-md-4">
                                        <img
                                            src="{{ asset('frontend/images/logo.png')}}"
                                            class="w-100 mb-3"
                                            alt=""
                                        />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-md-4 ml-5">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Pembeli</h6>
                                            <p>{{ $transactions_details->transaction->user->fullname }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Email</h6>
                                            <p>{{ $transactions_details->transaction->user->email }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>No Handphone</h6>
                                            <p>{{ $transactions_details->transaction->user->phone_number }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Provinsi</h6>
                                            <p>{{ $transactions_details->transaction->user->province->title }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kota</h6>
                                            <p>{{ $transactions_details->transaction->user->city->title }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Alamat Penerima</h6>
                                            <p>{{ $transactions_details->transaction->user->address }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Jasa Kurir</h6>
                                            <p>{{ $transactions_details->transaction->shipping_courier }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Biaya Kirim</h6>
                                            <p>{{ $transactions_details->transaction->shipping_price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nomor Resi</h6>
                                            <p>{{ $transactions_details->resi }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4" style="margin-left: 160px;">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kode Transaksi</h6>
                                            <p>{{ $transactions_details->transaction->code }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Tanggal Transaksi</h6>
                                            <p>{{ date('d F Y H:i',strtotime($transactions_details->transaction->transaction_date)) }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Barang</h6>
                                            <p>{{ $transactions_details->product->name }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Harga Barang</h6>
                                            <p>{{ $transactions_details->product->price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Jumlah</h6>
                                            <p>{{ $transactions_details->quantity }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kartu Ucapan</h6>
                                            <p>{{ $transactions_details->transaction->custom_card }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Toko</h6>
                                            <p>{{ $transactions_details->product->store->name }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Pemilik</h6>
                                            <p>{{ $transactions_details->product->store->user->fullname }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 col-md-4" style="margin-left: 160px;">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Total</h6>
                                            <p>{{ $transactions_details->transaction->total_price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Tanggal Transaksi</h6>
                                            <p>{{ $transactions_details->transaction->transaction_date }}</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('alltransaction.index') }}" class="btn btn-primary mb-4 float-right">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
