@extends('layouts.admin')

@section('title')
    Detail Transaksi Pengguna
@endsection

@section('content')
<!-- Section Content -->
    <div class="container-fluid" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading d-flex justify-content-between">
                <h5 class="dashboard-subtitle mt-2">
                   Detail Transaksi
                </h5>  
                <h2 class="dashboard-title">#{{ $transaction_to_all_detail->transaction->code }}</h2>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-lg-12 col-md-6">
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
                                    <div class="col-lg-5 col-md-4 col-xs-2 ml-5">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Pembeli</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->fullname }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Email</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->email }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>No Handphone</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->phone_number }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Provinsi</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->province->title }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kota</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->city->title }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Alamat Penerima</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->user->address }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Jasa Kurir</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->shipping_courier }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Biaya Kirim</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->shipping_price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nomor Resi</h6>
                                            <p>{{ $transaction_to_all_detail->resi }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-4 ml-5">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kode Transaksi</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->code }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Tanggal Transaksi</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->transaction_date }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Barang</h6>
                                            <p>{{ $transaction_to_all_detail->product->name }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Harga Barang</h6>
                                            <p>{{ $transaction_to_all_detail->product->price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Jumlah</h6>
                                            <p>{{ $transaction_to_all_detail->quantity }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Kartu Ucapan</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->custom_card }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-5 col-md-4 ml-5 mt-4">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nama Penjual</h6>
                                            <p>{{ $transaction_to_all_detail->product->store->user->fullname }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Email</h6>
                                            <p>{{ $transaction_to_all_detail->product->store->user->email }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>No Handphone</h6>
                                            <p>{{ $transaction_to_all_detail->product->store->user->phone_number }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Nomor Bank</h6>
                                            <p>{{ $transaction_to_all_detail->product->store->user->account_number }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-4 ml-5">
                                        <div class="row d-flex justify-content-between">
                                            <h6>Total</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->total_price }}</p>
                                        </div>
                                        <div class="row d-flex justify-content-between">
                                            <h6>Status Transaksi</h6>
                                            <p>{{ $transaction_to_all_detail->transaction->transaction_status }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-5 col-md-4 ml-5">
                                        <div class="row">
                                            <span>Transfer ke toko sejumlah {{ $transaction_to_all_detail->transaction->total_price }}
                                                ke toko {{ $transaction_to_all_detail->product->store->name }}. Kirim Email bahwa dana telah di transfer
                                            </span>
                                        </div>
                                        <a class="btn btn-outline-primary" href="{{ route('mailsend', $transaction_to_all_detail->code) }}">
                                            KIRIM EMAIL <i class="fas fa-envelope ml-4"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    
@endpush