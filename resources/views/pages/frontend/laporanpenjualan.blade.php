@extends('layouts.admin')

@section('title')
    Laporan Penjualan
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @hasanyrole('admin|seller')
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-10 col-12">
                    <h1 class="h3 mb-2 text-gray-900">Laporan Penjualan Toko</h1>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('pdflaporan')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="periode">PILIH PERIODE</label>
                            <div class="col-lg-9">
                                <select name="periode" id="" class="form-control">
                                    <option value="">Pilih Periode</option>
                                    <option value="hari ini">Hari Ini</option>
                                    <option value="januari">Januari</option>
                                    <option value="februari">Februari</option>
                                    <option value="maret">Maret</option>
                                    <option value="april">April</option>
                                    <option value="mei">Mei</option>
                                    <option value="juni">Juni</option>
                                    <option value="juli">Juli</option>
                                    <option value="agustus">Agustus</option>
                                    <option value="september">September</option>
                                    <option value="oktober">Oktober</option>
                                    <option value="november">November</option>
                                    <option value="desember">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-outline-primary float-right" type="submit">
                                    Print PDF <i class="far fa-download ml-4"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endhasanyrole

        @hasrole('admin')
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-10 col-12">
                    <h1 class="h3 mb-2 text-gray-900">Semua Laporan Penjualan Toko</h1>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('pdflaporanadmin')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label" for="periode">PILIH PERIODE</label>
                            <div class="col-lg-9">
                                <select name="periode" id="" class="form-control">
                                    <option value="">Pilih Periode</option>
                                    <option value="hari ini">Hari Ini</option>
                                    <option value="januari">Januari</option>
                                    <option value="februari">Februari</option>
                                    <option value="maret">Maret</option>
                                    <option value="april">April</option>
                                    <option value="mei">Mei</option>
                                    <option value="juni">Juni</option>
                                    <option value="juli">Juli</option>
                                    <option value="agustus">Agustus</option>
                                    <option value="september">September</option>
                                    <option value="oktober">Oktober</option>
                                    <option value="november">November</option>
                                    <option value="desember">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-outline-primary float-right" type="submit">
                                    Print PDF <i class="far fa-download ml-4"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endhasrole

    </div>
    <!-- /.container-fluid -->
@endsection

